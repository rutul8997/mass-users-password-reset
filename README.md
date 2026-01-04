# Mass Users Password Reset is a package that lets you resets the password of all users

[![Latest Version on Packagist](https://img.shields.io/packagist/v/rutul8997/mass-users-password-reset.svg?style=flat-square)](https://packagist.org/packages/rutul8997/mass-users-password-reset)
[![GitHub Tests Action Status](https://img.shields.io/github/actions/workflow/status/rutul8997/mass-users-password-reset/run-tests.yml?branch=main&label=tests&style=flat-square)](https://github.com/rutul8997/mass-users-password-reset/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/actions/workflow/status/rutul8997/mass-users-password-reset/fix-php-code-style-issues.yml?branch=main&label=code%20style&style=flat-square)](https://github.com/rutul8997/mass-users-password-reset/actions?query=workflow%3A"Fix+PHP+code+style+issues"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/rutul8997/mass-users-password-reset.svg?style=flat-square)](https://packagist.org/packages/rutul8997/mass-users-password-reset)

Mass Users Password Reset is a Laravel package that allows administrators to reset passwords for multiple users simultaneously. It provides a streamlined approach to password management with features like bulk password resets, email notifications, user filtering, and comprehensive logging.

## Support us

[<img src="https://github-ads.s3.eu-central-1.amazonaws.com/mass-users-password-reset.jpg?t=1" width="419px" />](https://spatie.be/github-ad-click/mass-users-password-reset)

We invest a lot of resources into creating [best in class open source packages](https://spatie.be/open-source). You can support us by [buying one of our paid products](https://spatie.be/open-source/support-us).

We highly appreciate you sending us a postcard from your hometown, mentioning which of our package(s) you are using. You'll find our address on [our contact page](https://spatie.be/about-us). We publish all received postcards on [our virtual postcard wall](https://spatie.be/open-source/postcards).

## Installation

You can install the package via composer:

```bash
composer require rutul8997/mass-users-password-reset
```

You can publish and run the migrations with:

```bash
php artisan vendor:publish --tag="mass-users-password-reset-migrations"
php artisan migrate
```

You can publish the config file with:

```bash
php artisan vendor:publish --tag="mass-users-password-reset-config"
```

This is the contents of the published config file:

```php
return [
    'route' => [
        'prefix' => 'admin/password-resets',
        'middleware' => ['web', 'auth'],
    ],
    'layout' => 'layouts.app',
    'section' => 'content',
    'password_length' => 12,
    'password_min_length' => 8,
    'enable_logging' => true,
    'user_model' => null,
];
```

Optionally, you can publish the views using

```bash
php artisan vendor:publish --tag="mass-users-password-reset-views"
```

## Usage

### Web Interface

After installation, you can access the mass password reset interface at:
```
/admin/password-resets
```

The interface allows you to:
- Select multiple users to reset passwords for
- Filter users by role or search by name/email
- Choose notification method (email, show on screen, or force change on next login)
- Optionally set a custom password for all selected users

### Using the Facade

```php
use Rutul\MassUsersPasswordReset\Facades\MassUsersPasswordReset;

// Reset password for a single user
$newPassword = MassUsersPasswordReset::resetUserPassword($user);

// Reset passwords for multiple users
$results = MassUsersPasswordReset::resetMultiplePasswords(
    [1, 2, 3], // User IDs
    null, // Custom password (null = auto-generate)
    auth()->user() // Initiator for logging
);

// Get users with filtering
$users = MassUsersPasswordReset::getUsers([
    'role' => 'admin',
    'search' => 'john',
]);

// Generate a secure password
$password = MassUsersPasswordReset::generatePassword(16);
```

### Using the Command Line

```bash
# Reset passwords for specific users
php artisan mass-users-password-reset --users=1 --users=2 --users=3

# Reset passwords for all users with a specific role
php artisan mass-users-password-reset --role=admin

# Reset passwords for all users
php artisan mass-users-password-reset --all

# Use a custom password
php artisan mass-users-password-reset --users=1 --password=MySecurePass123

# Send email notifications
php artisan mass-users-password-reset --users=1 --notify

# Set password length
php artisan mass-users-password-reset --users=1 --length=16
```

### Features

- **Bulk Password Reset**: Reset passwords for multiple users with a single action
- **User Filtering**: Filter users by role or search by name/email
- **Password Generation**: Automatically generate secure random passwords
- **Email Notifications**: Send password reset notifications via email
- **Logging**: Comprehensive logging of all password reset operations
- **Security**: Built-in authentication and authorization checks
- **Flexible**: Works with any Laravel authentication system

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [Rutul Thakkar](https://github.com/rutul8997)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
