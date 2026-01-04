# Quick Start: GUI Testing in Laravel Project

## 🚀 Fast Setup (5 minutes)

### 1. Install Package in Your Laravel Project

```bash
cd /path/to/your/laravel-project

# Add to composer.json repositories section:
{
    "repositories": [
        {
            "type": "path",
            "url": "/var/www/mass-users-password-reset"
        }
    ]
}

# Install
composer require rutul8997/mass-users-password-reset:dev-main
```

### 2. Publish Configuration

```bash
php artisan vendor:publish --tag="mass-users-password-reset-config"
```

### 3. Create Test Users

```bash
php artisan tinker
```

Then run:
```php
\App\Models\User::create(['name' => 'John Doe', 'email' => 'john@example.com', 'password' => bcrypt('password')]);
\App\Models\User::create(['name' => 'Jane Smith', 'email' => 'jane@example.com', 'password' => bcrypt('password')]);
\App\Models\User::create(['name' => 'Admin User', 'email' => 'admin@example.com', 'password' => bcrypt('password')]);
```

### 4. Start Server & Test

```bash
php artisan serve
```

1. Login to your app: `http://localhost:8000/login`
2. Go to: `http://localhost:8000/admin/password-resets`
3. Test the GUI!

## ✅ Quick Test Checklist

- [ ] Page loads at `/admin/password-resets`
- [ ] Users are displayed in table
- [ ] Can select users (checkbox)
- [ ] Can search users
- [ ] Can reset password (choose "Show password on screen")
- [ ] New password displays
- [ ] Can login with new password

## 📚 Full Documentation

- **Complete Guide:** `LARAVEL_PROJECT_TESTING.md`
- **Detailed Checklist:** `GUI_TEST_CHECKLIST.md`
- **Setup Script:** `./setup-test-project.sh`

## 🐛 Common Issues

**Route not found?**
```bash
php artisan route:clear
php artisan config:clear
```

**Users not showing?**
- Check you have users in database
- Verify User model exists

**403 Forbidden?**
- Make sure you're logged in
- Check middleware in config

## 🎯 What to Test

1. **User Selection** - Select one, multiple, all
2. **Search** - Search by name/email
3. **Password Reset** - Reset and verify new password works
4. **Custom Password** - Set same password for multiple users
5. **Email** - Send password via email (if mail configured)

That's it! Start testing! 🎉

