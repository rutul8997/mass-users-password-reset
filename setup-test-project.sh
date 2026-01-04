#!/bin/bash

# Script to help set up testing in a Laravel project

echo "=========================================="
echo "  Laravel Project GUI Testing Setup"
echo "=========================================="
echo ""

# Check if we're in a Laravel project
if [ ! -f "artisan" ]; then
    echo "❌ Error: This doesn't appear to be a Laravel project."
    echo "Please run this script from your Laravel project root directory."
    exit 1
fi

echo "✅ Laravel project detected"
echo ""

# Step 1: Install package
read -p "Do you want to install the package from local path? (y/n) " -n 1 -r
echo
if [[ $REPLY =~ ^[Yy]$ ]]; then
    PACKAGE_PATH="/var/www/mass-users-password-reset"
    
    if [ ! -d "$PACKAGE_PATH" ]; then
        read -p "Enter path to mass-users-password-reset package: " PACKAGE_PATH
    fi
    
    echo "Adding repository to composer.json..."
    
    # Check if repositories section exists
    if ! grep -q '"repositories"' composer.json; then
        # Add repositories section
        sed -i '/"require"/i\    "repositories": [\n        {\n            "type": "path",\n            "url": "'"$PACKAGE_PATH"'"\n        }\n    ],' composer.json
    else
        echo "⚠️  Repositories section already exists. Please add manually:"
        echo '    {'
        echo '        "type": "path",'
        echo "        \"url\": \"$PACKAGE_PATH\""
        echo '    },'
    fi
    
    echo "Installing package..."
    composer require rutul8997/mass-users-password-reset:dev-main
fi

# Step 2: Publish config
echo ""
read -p "Publish configuration file? (y/n) " -n 1 -r
echo
if [[ $REPLY =~ ^[Yy]$ ]]; then
    php artisan vendor:publish --tag="mass-users-password-reset-config"
    echo "✅ Configuration published to config/mass-users-password-reset.php"
fi

# Step 3: Publish views
echo ""
read -p "Publish views for customization? (y/n) " -n 1 -r
echo
if [[ $REPLY =~ ^[Yy]$ ]]; then
    php artisan vendor:publish --tag="mass-users-password-reset-views"
    echo "✅ Views published to resources/views/vendor/mass-users-password-reset/"
fi

# Step 4: Create test users
echo ""
read -p "Create test users? (y/n) " -n 1 -r
echo
if [[ $REPLY =~ ^[Yy]$ ]]; then
    php artisan tinker --execute="
    \App\Models\User::create(['name' => 'John Doe', 'email' => 'john@example.com', 'password' => bcrypt('password')]);
    \App\Models\User::create(['name' => 'Jane Smith', 'email' => 'jane@example.com', 'password' => bcrypt('password')]);
    \App\Models\User::create(['name' => 'Admin User', 'email' => 'admin@example.com', 'password' => bcrypt('password')]);
    echo 'Test users created successfully';
    "
    echo "✅ Test users created"
fi

# Step 5: Show route
echo ""
echo "=========================================="
echo "  Setup Complete!"
echo "=========================================="
echo ""
echo "Next steps:"
echo "1. Start your server: php artisan serve"
echo "2. Login to your application"
echo "3. Navigate to: http://localhost:8000/admin/password-resets"
echo ""
echo "Test users created:"
echo "  - john@example.com / password"
echo "  - jane@example.com / password"
echo "  - admin@example.com / password"
echo ""
echo "For detailed testing guide, see: LARAVEL_PROJECT_TESTING.md"
echo ""

