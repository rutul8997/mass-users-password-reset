<?php

namespace Rutul\MassUsersPasswordReset;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use Rutul\MassUsersPasswordReset\Commands\MassUsersPasswordResetCommand;

class MassUsersPasswordResetServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('mass-users-password-reset')
            ->hasConfigFile()
            ->hasViews()
            ->hasMigration('create_mass_users_password_reset_table')
            ->hasCommand(MassUsersPasswordResetCommand::class)
            ->hasRoutes(['web']); // This registers route files;
    }

    public function packageRegistered(): void
    {
        $this->app->singleton(
            \Rutul\MassUsersPasswordReset\Services\MassPasswordResetService::class
        );

        $this->app->singleton(
            MassUsersPasswordReset::class,
            function ($app) {
                return new MassUsersPasswordReset(
                    $app->make(\Rutul\MassUsersPasswordReset\Services\MassPasswordResetService::class)
                );
            }
        );
    }
}
