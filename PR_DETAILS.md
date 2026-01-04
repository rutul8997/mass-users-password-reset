# Pull Request Details

Use these details when creating pull requests one by one.

## 1. feature/core-service

**Title:** `feat: Add core password reset service and main class`

**Description:**
```markdown
## Core Password Reset Service

This PR adds the core functionality for mass password reset operations.

### Changes
- Add `MassPasswordResetService` with password generation and reset logic
- Add user filtering by role and search functionality  
- Add logging for password reset operations
- Update `MassUsersPasswordReset` main class with service methods
- Register service in service provider

### Files Changed
- `src/Services/MassPasswordResetService.php` (new)
- `src/MassUsersPasswordReset.php` (updated)
- `src/MassUsersPasswordResetServiceProvider.php` (updated)

### Stats
- 3 files changed
- 187 insertions(+), 2 deletions(-)
```

**URL:** https://github.com/rutul8997/mass-users-password-reset/compare/main...feature/core-service?expand=1

---

## 2. feature/notifications

**Title:** `feat: Add password reset email notification`

**Description:**
```markdown
## Email Notification System

This PR adds email notification functionality for password resets.

### Changes
- Create `PasswordResetNotification` class
- Support email notifications with new passwords
- Include security warnings and login instructions
- Queueable notification for better performance

### Files Changed
- `src/Notifications/PasswordResetNotification.php` (new)

### Stats
- 1 file changed
- 67 insertions(+)
```

**URL:** https://github.com/rutul8997/mass-users-password-reset/compare/main...feature/notifications?expand=1

---

## 3. feature/web-interface

**Title:** `feat: Add web interface for mass password reset`

**Description:**
```markdown
## Web Interface for Mass Password Reset

This PR adds a complete web interface for managing mass password resets.

### Changes
- Add `MassPasswordResetController` with index, store, and getUsers methods
- Add routes for password reset operations
- Update views with user selection, filtering, and password display
- Add search and role filtering functionality
- Support multiple notification methods (email, show, force change)
- Add form validation and error handling

### Files Changed
- `src/Http/Controllers/MassPasswordResetController.php` (updated)
- `src/routes/web.php` (updated)
- `resources/views/massusers-list.blade.php` (updated)
- `resources/views/components/user-select.blade.php` (updated)

### Stats
- 4 files changed
- 306 insertions(+), 85 deletions(-)
```

**URL:** https://github.com/rutul8997/mass-users-password-reset/compare/main...feature/web-interface?expand=1

---

## 4. feature/cli-command

**Title:** `feat: Add CLI command for mass password reset`

**Description:**
```markdown
## CLI Command for Mass Password Reset

This PR adds command-line interface support for mass password resets.

### Changes
- Add command options: `--users`, `--role`, `--all`, `--password`, `--notify`, `--length`
- Support bulk password reset via command line
- Add email notification support in CLI
- Display passwords in table format when not using `--notify`
- Add comprehensive error handling

### Files Changed
- `src/Commands/MassUsersPasswordResetCommand.php` (updated)

### Stats
- 1 file changed
- 105 insertions(+), 3 deletions(-)
```

**URL:** https://github.com/rutul8997/mass-users-password-reset/compare/main...feature/cli-command?expand=1

---

## 5. feature/config-updates

**Title:** `feat: Update configuration with new options`

**Description:**
```markdown
## Configuration Updates

This PR updates the configuration file with new options for better customization.

### Changes
- Add `password_min_length` configuration
- Add `enable_logging` toggle
- Add `user_model` configuration option
- Update route configuration structure

### Files Changed
- `config/mass-users-password-reset.php` (updated)

### Stats
- 1 file changed
- 12 insertions(+), 3 deletions(-)
```

**URL:** https://github.com/rutul8997/mass-users-password-reset/compare/main...feature/config-updates?expand=1

---

## 6. feature/documentation

**Title:** `docs: Update README with comprehensive usage guide`

**Description:**
```markdown
## Documentation Updates

This PR updates the README with comprehensive usage instructions and examples.

### Changes
- Add detailed feature descriptions
- Add web interface usage instructions
- Add facade usage examples
- Add CLI command examples with all options
- Update configuration documentation

### Files Changed
- `README.md` (updated)

### Stats
- 1 file changed
- 78 insertions(+), 3 deletions(-)
```

**URL:** https://github.com/rutul8997/mass-users-password-reset/compare/main...feature/documentation?expand=1

---

## Creating PRs

1. Open each URL above in your browser
2. Fill in the title and description from the details above
3. Click "Create Pull Request"
4. Repeat for the next branch

Or use the script:
```bash
./create-prs.sh feature/core-service
```

