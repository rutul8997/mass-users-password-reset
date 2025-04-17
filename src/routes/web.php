<?php

use Illuminate\Support\Facades\Route;
use Rutul\MassUsersPasswordReset\Http\Controllers\MassPasswordResetController;

Route::group(config('mass-password-reset.route'), function () {
    Route::get('/', [MassPasswordResetController::class, 'index'])
        ->name('mass-password-reset.index');
});