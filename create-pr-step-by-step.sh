#!/bin/bash

# Interactive script to create PRs one by one

REPO="rutul8997/mass-users-password-reset"
BASE_BRANCH="main"

declare -A PR_TITLES=(
    ["feature/core-service"]="feat: Add core password reset service and main class"
    ["feature/notifications"]="feat: Add password reset email notification"
    ["feature/web-interface"]="feat: Add web interface for mass password reset"
    ["feature/cli-command"]="feat: Add CLI command for mass password reset"
    ["feature/config-updates"]="feat: Update configuration with new options"
    ["feature/documentation"]="docs: Update README with comprehensive usage guide"
)

declare -A PR_DESCRIPTIONS=(
    ["feature/core-service"]="## Core Password Reset Service

This PR adds the core functionality for mass password reset operations.

### Changes
- Add \`MassPasswordResetService\` with password generation and reset logic
- Add user filtering by role and search functionality  
- Add logging for password reset operations
- Update \`MassUsersPasswordReset\` main class with service methods
- Register service in service provider

### Files Changed
- \`src/Services/MassPasswordResetService.php\` (new)
- \`src/MassUsersPasswordReset.php\` (updated)
- \`src/MassUsersPasswordResetServiceProvider.php\` (updated)"
    
    ["feature/notifications"]="## Email Notification System

This PR adds email notification functionality for password resets.

### Changes
- Create \`PasswordResetNotification\` class
- Support email notifications with new passwords
- Include security warnings and login instructions
- Queueable notification for better performance

### Files Changed
- \`src/Notifications/PasswordResetNotification.php\` (new)"
    
    ["feature/web-interface"]="## Web Interface for Mass Password Reset

This PR adds a complete web interface for managing mass password resets.

### Changes
- Add \`MassPasswordResetController\` with index, store, and getUsers methods
- Add routes for password reset operations
- Update views with user selection, filtering, and password display
- Add search and role filtering functionality
- Support multiple notification methods (email, show, force change)
- Add form validation and error handling"
    
    ["feature/cli-command"]="## CLI Command for Mass Password Reset

This PR adds command-line interface support for mass password resets.

### Changes
- Add command options: \`--users\`, \`--role\`, \`--all\`, \`--password\`, \`--notify\`, \`--length\`
- Support bulk password reset via command line
- Add email notification support in CLI
- Display passwords in table format when not using \`--notify\`
- Add comprehensive error handling"
    
    ["feature/config-updates"]="## Configuration Updates

This PR updates the configuration file with new options for better customization.

### Changes
- Add \`password_min_length\` configuration
- Add \`enable_logging\` toggle
- Add \`user_model\` configuration option
- Update route configuration structure"
    
    ["feature/documentation"]="## Documentation Updates

This PR updates the README with comprehensive usage instructions and examples.

### Changes
- Add detailed feature descriptions
- Add web interface usage instructions
- Add facade usage examples
- Add CLI command examples with all options
- Update configuration documentation"
)

branches=(
    "feature/core-service"
    "feature/notifications"
    "feature/web-interface"
    "feature/cli-command"
    "feature/config-updates"
    "feature/documentation"
)

echo "=========================================="
echo "  Create Pull Requests One by One"
echo "=========================================="
echo ""

for i in "${!branches[@]}"; do
    branch="${branches[$i]}"
    num=$((i+1))
    
    echo "PR #$num: $branch"
    echo "Title: ${PR_TITLES[$branch]}"
    echo ""
    echo "Description:"
    echo "${PR_DESCRIPTIONS[$branch]}"
    echo ""
    echo "URL: https://github.com/$REPO/compare/$BASE_BRANCH...$branch?expand=1"
    echo ""
    echo "----------------------------------------"
    echo ""
    
    read -p "Press Enter to open this PR page in browser (or 'q' to quit, 's' to skip)... " input
    
    if [ "$input" = "q" ]; then
        echo "Exiting..."
        exit 0
    elif [ "$input" = "s" ]; then
        echo "Skipping $branch..."
        echo ""
        continue
    fi
    
    # Open in browser
    url="https://github.com/$REPO/compare/$BASE_BRANCH...$branch?expand=1"
    
    if command -v xdg-open > /dev/null; then
        xdg-open "$url" 2>/dev/null
    elif command -v open > /dev/null; then
        open "$url" 2>/dev/null
    else
        echo "Please open this URL in your browser:"
        echo "$url"
    fi
    
    echo ""
    echo "PR page opened! Fill in the details and create the PR."
    echo "Then come back here and press Enter to continue to the next PR..."
    read -p ""
    echo ""
done

echo "All PRs processed!"

