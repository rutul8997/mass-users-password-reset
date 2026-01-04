# Testing in Laravel Project - GUI Testing Guide

This guide will help you test the Mass Users Password Reset package GUI in your Laravel project.

## Step 1: Install the Package

### Option A: Install from Local Path (Development)

```bash
# In your Laravel project's composer.json, add:
"repositories": [
    {
        "type": "path",
        "url": "/var/www/mass-users-password-reset"
    }
],

# Then install:
composer require rutul8997/mass-users-password-reset:dev-main
```

### Option B: Install via Composer (If Published)

```bash
composer require rutul8997/mass-users-password-reset
```

## Step 2: Publish Configuration

```bash
php artisan vendor:publish --tag="mass-users-password-reset-config"
```

This will create `config/mass-users-password-reset.php`

## Step 3: Publish Views (Optional - for customization)

```bash
php artisan vendor:publish --tag="mass-users-password-reset-views"
```

## Step 4: Configure Routes

The package automatically registers routes. Check your route list:

```bash
php artisan route:list | grep password-reset
```

Default route: `/admin/password-resets`

## Step 5: Set Up Authentication

Make sure you have authentication set up:

```bash
# If not already installed
composer require laravel/breeze
php artisan breeze:install
# OR
composer require laravel/ui
php artisan ui bootstrap --auth
```

## Step 6: Create Test Users

### Using Tinker

```bash
php artisan tinker
```

```php
// Create test users
\App\Models\User::factory()->create([
    'name' => 'John Doe',
    'email' => 'john@example.com',
    'password' => bcrypt('password')
]);

\App\Models\User::factory()->create([
    'name' => 'Jane Smith',
    'email' => 'jane@example.com',
    'password' => bcrypt('password')
]);

\App\Models\User::factory()->create([
    'name' => 'Admin User',
    'email' => 'admin@example.com',
    'password' => bcrypt('password')
]);
```

### Using Seeder

Create a seeder:

```bash
php artisan make:seeder TestUsersSeeder
```

```php
<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class TestUsersSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'password' => Hash::make('password'),
        ]);

        User::create([
            'name' => 'Jane Smith',
            'email' => 'jane@example.com',
            'password' => Hash::make('password'),
        ]);

        User::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
        ]);
    }
}
```

Run seeder:
```bash
php artisan db:seed --class=TestUsersSeeder
```

## Step 7: Test the GUI

### 7.1 Start Your Development Server

```bash
php artisan serve
```

### 7.2 Access the Interface

1. **Login** to your Laravel application
2. **Navigate** to: `http://localhost:8000/admin/password-resets`
   (or your configured route prefix)

### 7.3 GUI Testing Checklist

#### ✅ User List Display
- [ ] Users are displayed in a table
- [ ] User ID, Name, and Email columns are visible
- [ ] "Select All" checkbox works
- [ ] Individual checkboxes work

#### ✅ Search Functionality
- [ ] Search by name works (e.g., type "John")
- [ ] Search by email works (e.g., type "john@")
- [ ] Search results update correctly
- [ ] Clear filters button works

#### ✅ Role Filtering (if applicable)
- [ ] Role filter input is visible
- [ ] Filtering by role works (if you have roles set up)

#### ✅ Password Reset - Show Method
- [ ] Select one user
- [ ] Choose "Show password on screen"
- [ ] Click "Reset Passwords"
- [ ] Success message appears
- [ ] New password is displayed in a table
- [ ] Can copy the password
- [ ] Try logging in with the new password

#### ✅ Password Reset - Multiple Users
- [ ] Select multiple users (2-3 users)
- [ ] Choose "Show password on screen"
- [ ] Click "Reset Passwords"
- [ ] All passwords are displayed
- [ ] Each user has a different password (unless custom password used)

#### ✅ Custom Password
- [ ] Select users
- [ ] Enter custom password: "TestPass123!"
- [ ] Choose notification method
- [ ] Submit form
- [ ] Verify all selected users get the same password
- [ ] Test login with custom password

#### ✅ Email Notification
- [ ] Configure mail in `.env` (use Mailtrap for testing)
- [ ] Select users
- [ ] Choose "Email users their new password"
- [ ] Submit form
- [ ] Check email inbox
- [ ] Verify email contains new password
- [ ] Verify email has security warnings

#### ✅ Form Validation
- [ ] Try submitting without selecting users (should show error)
- [ ] Try with invalid user ID (should show validation error)
- [ ] Try with password less than 8 characters (should show error)

#### ✅ UI/UX
- [ ] Page loads without errors
- [ ] Styling looks correct (Bootstrap/Tailwind)
- [ ] Responsive on mobile
- [ ] Success/error messages display properly
- [ ] Loading states work (if implemented)

## Step 8: Test CLI Command

```bash
# Test basic command
php artisan mass-users-password-reset --users=1

# Test with multiple users
php artisan mass-users-password-reset --users=1 --users=2

# Test with custom password
php artisan mass-users-password-reset --users=1 --password=Test123!

# Test with email notification
php artisan mass-users-password-reset --users=1 --notify
```

## Step 9: Check Logs

After testing, check logs for password reset operations:

```bash
tail -f storage/logs/laravel.log
```

Look for entries like:
```
Password reset performed
user_id: 1
user_email: john@example.com
initiated_by: 1
```

## Troubleshooting

### Issue: Route not found
**Solution:** 
- Check if routes are registered: `php artisan route:list`
- Clear route cache: `php artisan route:clear`
- Clear config cache: `php artisan config:clear`

### Issue: View not found
**Solution:**
- Publish views: `php artisan vendor:publish --tag="mass-users-password-reset-views"`
- Check view namespace in config

### Issue: 403 Forbidden
**Solution:**
- Check middleware in config: `config/mass-users-password-reset.php`
- Ensure you're authenticated
- Check authorization policies if you have them

### Issue: Users not displaying
**Solution:**
- Verify you have users in database
- Check User model matches Laravel's default
- Check database connection

### Issue: Styling issues
**Solution:**
- Ensure Bootstrap/Tailwind CSS is loaded
- Check if layout extends correct file
- Publish and customize views if needed

## Quick Test Script

Create a test route to quickly verify everything works:

```php
// routes/web.php (temporary for testing)
Route::get('/test-password-reset', function () {
    $service = app(\Rutul\MassUsersPasswordReset\Services\MassPasswordResetService::class);
    
    // Get users
    $users = $service->getUsers();
    
    return view('test', ['users' => $users]);
})->middleware('auth');
```

## Next Steps

After confirming GUI works:
1. Remove test users if needed
2. Configure proper authentication/authorization
3. Customize views if needed
4. Set up email configuration for production
5. Review and adjust logging settings

