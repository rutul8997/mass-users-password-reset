<?php

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Rutul\MassUsersPasswordReset\Services\MassPasswordResetService;

uses(RefreshDatabase::class);

beforeEach(function () {
    // Setup database
    config()->set('database.default', 'testing');
    config()->set('database.connections.testing', [
        'driver' => 'sqlite',
        'database' => ':memory:',
        'prefix' => '',
    ]);
});

it('can generate a password', function () {
    $service = app(MassPasswordResetService::class);
    $password = $service->generatePassword(12);

    expect($password)->not->toBeEmpty()
        ->and(strlen($password))->toBe(12);
});

it('can generate passwords of different lengths', function () {
    $service = app(MassPasswordResetService::class);
    $password8 = $service->generatePassword(8);
    $password16 = $service->generatePassword(16);

    expect(strlen($password8))->toBe(8)
        ->and(strlen($password16))->toBe(16);
});

it('can reset password for a user', function () {
    $service = app(MassPasswordResetService::class);
    $user = createUser();
    $oldPassword = $user->password;

    $newPassword = $service->resetUserPassword($user);

    $user->refresh();
    expect($user->password)->not->toBe($oldPassword)
        ->and($newPassword)->not->toBeEmpty()
        ->and(Hash::check($newPassword, $user->password))->toBeTrue();
});

it('can reset password with custom password', function () {
    $service = app(MassPasswordResetService::class);
    $user = createUser();
    $customPassword = 'CustomPass123!';

    $newPassword = $service->resetUserPassword($user, $customPassword);

    $user->refresh();
    expect($newPassword)->toBe($customPassword)
        ->and(Hash::check($customPassword, $user->password))->toBeTrue();
});

it('can reset passwords for multiple users', function () {
    $service = app(MassPasswordResetService::class);
    $user1 = createUser();
    $user2 = createUser();
    $user3 = createUser();

    $results = $service->resetMultiplePasswords([
        $user1->id,
        $user2->id,
        $user3->id,
    ]);

    expect($results['success'])->toBe(3)
        ->and($results['failed'])->toBe(0)
        ->and($results['passwords'])->toHaveCount(3)
        ->and($results['passwords'])->toHaveKey($user1->id)
        ->and($results['passwords'])->toHaveKey($user2->id)
        ->and($results['passwords'])->toHaveKey($user3->id);
});

it('can get users without filters', function () {
    $service = app(MassPasswordResetService::class);
    createUser(['name' => 'John Doe', 'email' => 'john@example.com']);
    createUser(['name' => 'Jane Doe', 'email' => 'jane@example.com']);

    $users = $service->getUsers();

    expect($users)->toHaveCount(2);
});

it('can filter users by search', function () {
    $service = app(MassPasswordResetService::class);
    createUser(['name' => 'John Doe', 'email' => 'john@example.com']);
    createUser(['name' => 'Jane Smith', 'email' => 'jane@example.com']);

    $users = $service->getUsers(['search' => 'John']);

    expect($users)->toHaveCount(1)
        ->and($users->first()->name)->toBe('John Doe');
});

function createUser(array $attributes = [])
{
    $userModel = config('auth.providers.users.model', \Illuminate\Foundation\Auth\User::class);

    if (! class_exists($userModel)) {
        // Fallback to a simple user creation for testing
        $userModel = \Illuminate\Foundation\Auth\User::class;
    }

    return $userModel::factory()->create(array_merge([
        'name' => 'Test User',
        'email' => 'test@example.com',
        'password' => Hash::make('password'),
    ], $attributes));
}

