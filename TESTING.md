# Testing Guide

This guide explains how to test the Mass Users Password Reset package functionality.

## Running Tests

### Run All Tests
```bash
composer test
# or
vendor/bin/pest
```

### Run Specific Test File
```bash
vendor/bin/pest tests/Feature/MassPasswordResetServiceTest.php
```

### Run with Coverage
```bash
composer test-coverage
# or
vendor/bin/pest --coverage
```

### Run Specific Test
```bash
vendor/bin/pest --filter "can generate a password"
```

## Test Structure

### Unit Tests
- `tests/Unit/MassPasswordResetCommandTest.php` - Tests for CLI command

### Feature Tests
- `tests/Feature/MassPasswordResetServiceTest.php` - Tests for service layer
- `tests/Feature/MassPasswordResetControllerTest.php` - Tests for web interface

## Manual Testing

### 1. Testing in a Laravel Application

#### Install the Package
```bash
# In your Laravel application
composer require rutul8997/mass-users-password-reset
```

#### Publish Configuration
```bash
php artisan vendor:publish --tag="mass-users-password-reset-config"
```

#### Publish Views (Optional)
```bash
php artisan vendor:publish --tag="mass-users-password-reset-views"
```

### 2. Test Web Interface

1. **Access the Interface**
   - Navigate to: `http://your-app.test/admin/password-resets`
   - Make sure you're logged in as an authenticated user

2. **Test User Selection**
   - Verify users are displayed in the table
   - Test "Select All" checkbox functionality
   - Test individual user selection

3. **Test Filtering**
   - Test search by name: Enter a user's name
   - Test search by email: Enter a user's email
   - Test role filtering (if you have roles set up)

4. **Test Password Reset**
   - Select one or more users
   - Choose notification method: "Show password on screen"
   - Click "Reset Passwords"
   - Verify new passwords are displayed
   - Try logging in with the new password

5. **Test Email Notifications**
   - Select users
   - Choose "Email users their new password"
   - Submit the form
   - Check email inbox for password reset notifications

6. **Test Custom Password**
   - Select users
   - Enter a custom password (minimum 8 characters)
   - Submit and verify all users get the same password

### 3. Test CLI Command

#### Reset Passwords for Specific Users
```bash
php artisan mass-users-password-reset --users=1 --users=2 --users=3
```

#### Reset Passwords for All Users in a Role
```bash
php artisan mass-users-password-reset --role=admin
```

#### Reset Passwords for All Users
```bash
php artisan mass-users-password-reset --all
```

#### Use Custom Password
```bash
php artisan mass-users-password-reset --users=1 --password=MySecurePass123
```

#### Send Email Notifications
```bash
php artisan mass-users-password-reset --users=1 --notify
```

#### Set Password Length
```bash
php artisan mass-users-password-reset --users=1 --length=16
```

### 4. Test Using Facade

Create a test route or use Tinker:

```php
use Rutul\MassUsersPasswordReset\Facades\MassUsersPasswordReset;

// Generate a password
$password = MassUsersPasswordReset::generatePassword(12);

// Reset password for a user
$user = User::find(1);
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
```

### 5. Test Email Notifications

1. **Configure Mail**
   - Set up your mail configuration in `.env`
   - Use Mailtrap or similar for testing

2. **Test Notification**
   ```bash
   php artisan mass-users-password-reset --users=1 --notify
   ```

3. **Verify Email**
   - Check your mail inbox
   - Verify the email contains the new password
   - Verify security warnings are included

### 6. Test Logging

1. **Enable Logging**
   - Ensure `enable_logging` is `true` in config

2. **Perform Password Reset**
   - Use web interface or CLI

3. **Check Logs**
   ```bash
   tail -f storage/logs/laravel.log
   ```
   - Look for "Password reset performed" entries
   - Verify user ID, email, and initiator are logged

## Test Scenarios

### Scenario 1: Basic Password Reset
1. Select 3 users
2. Reset passwords with "show" notification
3. Verify all 3 users get new passwords
4. Test login with new passwords

### Scenario 2: Bulk Reset with Email
1. Select 10 users
2. Reset passwords with "email" notification
3. Verify all users receive emails
4. Check email content is correct

### Scenario 3: Custom Password
1. Select 5 users
2. Set custom password: "TempPass123!"
3. Verify all users get the same password
4. Test login with custom password

### Scenario 4: Filtering
1. Search for users by name
2. Filter by role (if applicable)
3. Select filtered users
4. Reset passwords

### Scenario 5: Error Handling
1. Try to reset without selecting users (should show error)
2. Try invalid user ID (should show validation error)
3. Try custom password less than 8 characters (should show error)

## Troubleshooting Tests

### Issue: Tests can't find User model
**Solution:** Make sure you have a User model in your test setup. The package uses Laravel's default User model.

### Issue: Routes not found
**Solution:** Ensure routes are registered. Check `MassUsersPasswordResetServiceProvider` configuration.

### Issue: Views not found
**Solution:** Publish views or ensure view namespace is correct: `mass-users-password-reset::`

### Issue: Database errors in tests
**Solution:** Ensure test database is configured. Check `phpunit.xml.dist` and test setup.

## Continuous Integration

Tests are automatically run on:
- Push to repository
- Pull requests
- Multiple PHP versions (8.3, 8.4)
- Multiple Laravel versions (10.x, 11.x)

See `.github/workflows/run-tests.yml` for CI configuration.

