<?php

namespace Rutul\MassUsersPasswordReset\Services;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\Contracts\Auth\Authenticatable;

class MassPasswordResetService
{
    /**
     * Generate a secure random password
     */
    public function generatePassword(int $length = 12): string
    {
        return Str::random($length);
    }

    /**
     * Reset password for a single user
     */
    public function resetUserPassword(Authenticatable $user, ?string $customPassword = null): string
    {
        $newPassword = $customPassword ?? $this->generatePassword(
            config('mass-users-password-reset.password_length', 12)
        );

        $user->password = Hash::make($newPassword);
        $user->save();

        return $newPassword;
    }

    /**
     * Reset passwords for multiple users
     *
     * @param array $userIds Array of user IDs
     * @param string|null $customPassword Optional custom password for all users
     * @param Authenticatable|null $initiator The admin who initiated the reset
     * @return array Array with 'success' count and 'passwords' mapping user_id => password
     */
    public function resetMultiplePasswords(
        array $userIds,
        ?string $customPassword = null,
        ?Authenticatable $initiator = null
    ): array {
        $userModel = config('auth.providers.users.model', \App\Models\User::class);
        $users = $userModel::whereIn('id', $userIds)->get();

        $results = [
            'success' => 0,
            'failed' => 0,
            'passwords' => [],
        ];

        foreach ($users as $user) {
            try {
                $newPassword = $this->resetUserPassword($user, $customPassword);
                $results['passwords'][$user->id] = $newPassword;
                $results['success']++;

                // Log the password reset
                $this->logPasswordReset($user, $initiator);
            } catch (\Exception $e) {
                $results['failed']++;
                Log::error('Failed to reset password for user ID: ' . $user->id, [
                    'error' => $e->getMessage(),
                ]);
            }
        }

        return $results;
    }

    /**
     * Log password reset operation
     */
    protected function logPasswordReset(Authenticatable $user, ?Authenticatable $initiator = null): void
    {
        Log::info('Password reset performed', [
            'user_id' => $user->id,
            'user_email' => $user->email ?? 'N/A',
            'initiated_by' => $initiator?->id ?? 'System',
            'initiated_by_email' => $initiator?->email ?? 'N/A',
            'timestamp' => now()->toDateTimeString(),
        ]);
    }

    /**
     * Get users with optional filtering
     *
     * @param array $filters Optional filters (role, search, etc.)
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getUsers(array $filters = [])
    {
        $userModel = config('auth.providers.users.model', \App\Models\User::class);
        $query = $userModel::query();

        // Filter by role if provided
        if (isset($filters['role']) && !empty($filters['role'])) {
            if (method_exists($userModel, 'role')) {
                $query->role($filters['role']);
            } elseif (method_exists($query->getModel(), 'whereHas')) {
                $query->whereHas('roles', function ($q) use ($filters) {
                    $q->where('name', $filters['role']);
                });
            }
        }

        // Search by name or email
        if (isset($filters['search']) && !empty($filters['search'])) {
            $search = $filters['search'];
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            });
        }

        return $query->orderBy('name')->get();
    }
}

