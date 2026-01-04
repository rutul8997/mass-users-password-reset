<?php

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;
use Rutul\MassUsersPasswordReset\Notifications\PasswordResetNotification;

uses(RefreshDatabase::class);

beforeEach(function () {
    Notification::fake();
});

it('can send password reset notification', function () {
    $user = createUser();
    $password = 'NewPassword123!';

    $user->notify(new PasswordResetNotification($password, 'Admin User'));

    Notification::assertSentTo($user, PasswordResetNotification::class);
});

it('includes password in notification', function () {
    $user = createUser();
    $password = 'NewPassword123!';

    $notification = new PasswordResetNotification($password, 'Admin User');
    $mailMessage = $notification->toMail($user);

    expect($mailMessage->subject)->toBe('Your Password Has Been Reset')
        ->and($mailMessage->introLines)->toContain('Your new temporary password is: **' . $password . '**');
});

function createUser(array $attributes = [])
{
    $userModel = config('auth.providers.users.model', \Illuminate\Foundation\Auth\User::class);

    if (! class_exists($userModel)) {
        $userModel = \Illuminate\Foundation\Auth\User::class;
    }

    return $userModel::factory()->create(array_merge([
        'name' => 'Test User',
        'email' => 'test@example.com',
        'password' => \Illuminate\Support\Facades\Hash::make('password'),
    ], $attributes));
}

