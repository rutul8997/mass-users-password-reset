<?php

it('can list available command options', function () {
    $this->artisan('mass-users-password-reset --help')
        ->assertSuccessful();
});

it('requires at least one option', function () {
    $this->artisan('mass-users-password-reset')
        ->expectsOutput('No users selected')
        ->assertFailed();
});

