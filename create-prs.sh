#!/bin/bash

# Script to help create pull requests one by one
# Usage: ./create-prs.sh [branch-name]

REPO="rutul8997/mass-users-password-reset"
BASE_BRANCH="main"

branches=(
    "feature/core-service:Core Password Reset Service"
    "feature/notifications:Email Notification System"
    "feature/web-interface:Web Interface for Mass Password Reset"
    "feature/cli-command:CLI Command for Mass Password Reset"
    "feature/config-updates:Configuration Updates"
    "feature/documentation:Documentation Updates"
)

if [ -n "$1" ]; then
    # Create PR for specific branch
    branch=$1
    title=$(echo "$branch" | cut -d: -f2)
    branch_name=$(echo "$branch" | cut -d: -f1)
    
    echo "Creating PR for: $branch_name"
    echo "Title: $title"
    echo ""
    echo "Opening GitHub PR creation page..."
    echo "URL: https://github.com/$REPO/compare/$BASE_BRANCH...$branch_name"
    
    # Try to open in browser (works on most systems)
    if command -v xdg-open > /dev/null; then
        xdg-open "https://github.com/$REPO/compare/$BASE_BRANCH...$branch_name?expand=1"
    elif command -v open > /dev/null; then
        open "https://github.com/$REPO/compare/$BASE_BRANCH...$branch_name?expand=1"
    else
        echo "Please open this URL in your browser:"
        echo "https://github.com/$REPO/compare/$BASE_BRANCH...$branch_name?expand=1"
    fi
else
    # Show all branches
    echo "Available branches to create PRs for:"
    echo ""
    for i in "${!branches[@]}"; do
        branch_info="${branches[$i]}"
        branch_name=$(echo "$branch_info" | cut -d: -f1)
        title=$(echo "$branch_info" | cut -d: -f2)
        num=$((i+1))
        echo "$num. $branch_name"
        echo "   Title: $title"
        echo "   URL: https://github.com/$REPO/compare/$BASE_BRANCH...$branch_name?expand=1"
        echo ""
    done
    
    echo "To create a PR, run:"
    echo "  ./create-prs.sh feature/core-service"
    echo ""
    echo "Or open the URLs above in your browser."
fi

