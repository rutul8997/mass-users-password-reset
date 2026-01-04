<?php

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;

uses(RefreshDatabase::class);

beforeEach(function () {
    // Setup database
    config()->set('database.default', 'testing');
    config()->set('database.connections.testing', [
        'driver' => 'sqlite',
        'database' => ':memory:',
        'prefix' => '',
    ]);

    // Setup routes
    app('router')->middleware(['web'])->group(function ($router) {
        require __DIR__ . '/../../src/routes/web.php';
    });
});

it('can display the password reset page', function () {
    $user = createUser();
    
    $response = $this->actingAs($user)
        ->get(route('mass-users-password-reset.index'));

    $response->assertStatus(200)
        ->assertViewIs('mass-users-password-reset::massusers-list');
});

it('requires authentication', function () {
    $response = $this->get(route('mass-users-password-reset.index'));

    $response->assertRedirect(route('login'));
});

it('can reset passwords for selected users', function () {
    $admin = createUser();
    $user1 = createUser(['email' => 'user1@example.com']);
    $user2 = createUser(['email' => 'user2@example.com']);

    $response = $this->actingAs($admin)
        ->post(route('mass-users-password-reset.store'), [
            'user_ids' => [$user1->id, $user2->id],
            'notification_method' => 'show',
        ]);

    $response->assertRedirect()
        ->assertSessionHas('success');

    // Verify passwords were changed
    expect(Hash::check('password', $user1->fresh()->password))->toBeFalse();
});

it('validates required fields', function () {
    $admin = createUser();

    $response = $this->actingAs($admin)
        ->post(route('mass-users-password-reset.store'), []);

    $response->assertSessionHasErrors(['user_ids', 'notification_method']);
});

it('validates user ids exist', function () {
    $admin = createUser();

    $response = $this->actingAs($admin)
        ->post(route('mass-users-password-reset.store'), [
            'user_ids' => [99999], // Non-existent user
            'notification_method' => 'show',
        ]);

    $response->assertSessionHasErrors(['user_ids.0']);
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
        'password' => Hash::make('password'),
    ], $attributes));
}

