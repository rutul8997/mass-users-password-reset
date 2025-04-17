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
            ->hasRoutes(['web', 'api']); // This registers route files;
    }
}
