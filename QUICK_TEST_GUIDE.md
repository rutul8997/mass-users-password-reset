# Quick Testing Guide

## Run Tests

```bash
# Run all tests
composer test

# Run specific test file
vendor/bin/pest tests/Feature/MassPasswordResetServiceTest.php

# Run with filter
vendor/bin/pest --filter "can generate a password"
```

## Manual Testing Checklist

### Web Interface
- [ ] Access `/admin/password-resets`
- [ ] Verify user list displays
- [ ] Test user selection (individual and select all)
- [ ] Test search functionality
- [ ] Test role filtering (if applicable)
- [ ] Reset passwords with "show" method
- [ ] Reset passwords with "email" method
- [ ] Test custom password option
- [ ] Verify form validation

### CLI Command
- [ ] `php artisan mass-users-password-reset --users=1`
- [ ] `php artisan mass-users-password-reset --all`
- [ ] `php artisan mass-users-password-reset --role=admin`
- [ ] `php artisan mass-users-password-reset --users=1 --password=Test123!`
- [ ] `php artisan mass-users-password-reset --users=1 --notify`
- [ ] `php artisan mass-users-password-reset --users=1 --length=16`

### Facade Usage
```php
use Rutul\MassUsersPasswordReset\Facades\MassUsersPasswordReset;

// In Tinker or a test route
$password = MassUsersPasswordReset::generatePassword(12);
$results = MassUsersPasswordReset::resetMultiplePasswords([1, 2, 3]);
```

See TESTING.md for detailed instructions.
