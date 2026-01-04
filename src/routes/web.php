<?php

use Illuminate\Support\Facades\Route;
use Rutul\MassUsersPasswordReset\Http\Controllers\MassPasswordResetController;

Route::group(config('mass-users-password-reset.route', []), function () {
    Route::get('/', [MassPasswordResetController::class, 'index'])
        ->name('mass-users-password-reset.index');
    
    Route::post('/', [MassPasswordResetController::class, 'store'])
        ->name('mass-users-password-reset.store');
    
    Route::get('/users', [MassPasswordResetController::class, 'getUsers'])
        ->name('mass-users-password-reset.users');
});