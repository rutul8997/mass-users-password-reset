<?php

namespace Rutul\MassUsersPasswordReset;

use Rutul\MassUsersPasswordReset\Services\MassPasswordResetService;

class MassUsersPasswordReset
{
    protected MassPasswordResetService $service;

    public function __construct(MassPasswordResetService $service)
    {
        $this->service = $service;
    }

    /**
     * Reset password for a single user
     */
    public function resetUserPassword($user, ?string $customPassword = null): string
    {
        return $this->service->resetUserPassword($user, $customPassword);
    }

    /**
     * Reset passwords for multiple users
     */
    public function resetMultiplePasswords(
        array $userIds,
        ?string $customPassword = null,
        $initiator = null
    ): array {
        return $this->service->resetMultiplePasswords($userIds, $customPassword, $initiator);
    }

    /**
     * Get users with optional filtering
     */
    public function getUsers(array $filters = [])
    {
        return $this->service->getUsers($filters);
    }

    /**
     * Generate a secure random password
     */
    public function generatePassword(int $length = 12): string
    {
        return $this->service->generatePassword($length);
    }
}
