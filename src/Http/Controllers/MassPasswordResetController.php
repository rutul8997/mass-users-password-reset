<?php

namespace Rutul\MassUsersPasswordReset\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;
use Rutul\MassUsersPasswordReset\Notifications\PasswordResetNotification;
use Rutul\MassUsersPasswordReset\Services\MassPasswordResetService;

class MassPasswordResetController
{
    protected MassPasswordResetService $service;

    public function __construct(MassPasswordResetService $service)
    {
        $this->service = $service;
    }

    /**
     * Display the mass password reset form
     */
    public function index(Request $request)
    {
        $filters = [
            'role' => $request->get('role'),
            'search' => $request->get('search'),
        ];

        $users = $this->service->getUsers($filters);

        return view('mass-users-password-reset::massusers-list', [
            'users' => $users,
            'filters' => $filters,
        ]);
    }

    /**
     * Get users via AJAX (for filtering)
     */
    public function getUsers(Request $request)
    {
        $filters = [
            'role' => $request->get('role'),
            'search' => $request->get('search'),
        ];

        $users = $this->service->getUsers($filters);

        return response()->json([
            'users' => $users->map(function ($user) {
                return [
                    'id' => $user->id,
                    'name' => $user->name ?? 'N/A',
                    'email' => $user->email ?? 'N/A',
                ];
            }),
        ]);
    }

    /**
     * Handle password reset submission
     */
    public function store(Request $request)
    {
        $request->validate([
            'user_ids' => 'required|array|min:1',
            'user_ids.*' => 'required|integer|exists:users,id',
            'notification_method' => 'required|in:email,show,force_change',
            'custom_password' => 'nullable|string|min:8',
        ]);

        $userIds = $request->input('user_ids');
        $notificationMethod = $request->input('notification_method');
        $customPassword = $request->input('custom_password');
        $initiator = Auth::user();

        // Reset passwords
        $results = $this->service->resetMultiplePasswords(
            $userIds,
            $customPassword,
            $initiator
        );

        if ($results['success'] === 0) {
            return back()->withErrors([
                'error' => 'Failed to reset passwords for selected users.',
            ]);
        }

        // Handle notifications based on method
        if ($notificationMethod === 'email') {
            $this->sendEmailNotifications($userIds, $results['passwords'], $initiator);
        }

        $message = "Successfully reset passwords for {$results['success']} user(s).";
        
        if ($notificationMethod === 'show') {
            return back()->with([
                'success' => $message,
                'passwords' => $results['passwords'],
            ]);
        }

        return back()->with('success', $message);
    }

    /**
     * Send email notifications to users
     */
    protected function sendEmailNotifications(
        array $userIds,
        array $passwords,
        $initiator
    ): void {
        $userModel = config('auth.providers.users.model', \App\Models\User::class);
        $users = $userModel::whereIn('id', $userIds)->get();

        foreach ($users as $user) {
            if (isset($passwords[$user->id])) {
                try {
                    $user->notify(new PasswordResetNotification(
                        $passwords[$user->id],
                        $initiator?->name ?? 'Administrator'
                    ));
                } catch (\Exception $e) {
                    \Log::error('Failed to send password reset notification', [
                        'user_id' => $user->id,
                        'error' => $e->getMessage(),
                    ]);
                }
            }
        }
    }
}
