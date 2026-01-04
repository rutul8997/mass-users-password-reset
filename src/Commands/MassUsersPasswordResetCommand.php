<?php

namespace Rutul\MassUsersPasswordReset\Commands;

use Illuminate\Console\Command;
use Rutul\MassUsersPasswordReset\Services\MassPasswordResetService;
use Rutul\MassUsersPasswordReset\Notifications\PasswordResetNotification;

class MassUsersPasswordResetCommand extends Command
{
    public $signature = 'mass-users-password-reset 
                        {--users=* : User IDs to reset passwords for}
                        {--role= : Filter users by role}
                        {--all : Reset passwords for all users}
                        {--password= : Custom password for all users}
                        {--notify : Send email notifications to users}
                        {--length=12 : Password length for generated passwords}';

    public $description = 'Reset passwords for multiple users via command line';

    protected MassPasswordResetService $service;

    public function __construct(MassPasswordResetService $service)
    {
        parent::__construct();
        $this->service = $service;
    }

    public function handle(): int
    {
        $userIds = $this->getUserIds();
        
        if (empty($userIds)) {
            $this->error('No users selected. Use --users, --role, or --all option.');
            return self::FAILURE;
        }

        $customPassword = $this->option('password');
        $passwordLength = (int) $this->option('length');

        if (!$customPassword) {
            // Temporarily override config for this command
            config(['mass-users-password-reset.password_length' => $passwordLength]);
        }

        $this->info("Resetting passwords for " . count($userIds) . " user(s)...");

        $results = $this->service->resetMultiplePasswords(
            $userIds,
            $customPassword
        );

        if ($results['success'] > 0) {
            $this->info("✓ Successfully reset passwords for {$results['success']} user(s).");
            
            // Display passwords
            if ($this->option('notify')) {
                $this->sendNotifications($userIds, $results['passwords']);
                $this->info("✓ Email notifications sent.");
            } else {
                $this->warn("\nGenerated Passwords:");
                $this->table(
                    ['User ID', 'Password'],
                    collect($results['passwords'])->map(fn($pwd, $id) => [$id, $pwd])->toArray()
                );
                $this->warn("⚠ Please save these passwords securely. They will not be shown again.");
            }

            if ($results['failed'] > 0) {
                $this->warn("⚠ Failed to reset passwords for {$results['failed']} user(s).");
            }
        } else {
            $this->error("Failed to reset passwords for any users.");
            return self::FAILURE;
        }

        return self::SUCCESS;
    }

    protected function getUserIds(): array
    {
        $userModel = config('auth.providers.users.model', \App\Models\User::class);

        if ($this->option('all')) {
            return $userModel::pluck('id')->toArray();
        }

        if ($this->option('role')) {
            $query = $userModel::query();
            if (method_exists($userModel, 'role')) {
                $query->role($this->option('role'));
            } elseif (method_exists($query->getModel(), 'whereHas')) {
                $query->whereHas('roles', function ($q) {
                    $q->where('name', $this->option('role'));
                });
            }
            return $query->pluck('id')->toArray();
        }

        return $this->option('users') ?? [];
    }

    protected function sendNotifications(array $userIds, array $passwords): void
    {
        $userModel = config('auth.providers.users.model', \App\Models\User::class);
        $users = $userModel::whereIn('id', $userIds)->get();

        foreach ($users as $user) {
            if (isset($passwords[$user->id])) {
                try {
                    $user->notify(new PasswordResetNotification(
                        $passwords[$user->id],
                        'System Administrator'
                    ));
                } catch (\Exception $e) {
                    $this->warn("Failed to send notification to user {$user->id}: " . $e->getMessage());
                }
            }
        }
    }
}
