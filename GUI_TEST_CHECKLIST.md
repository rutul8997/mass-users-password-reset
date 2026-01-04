# GUI Testing Checklist

Use this checklist to systematically test the Mass Users Password Reset GUI in your Laravel project.

## Pre-Testing Setup

- [ ] Package installed in Laravel project
- [ ] Configuration published
- [ ] At least 3-5 test users created
- [ ] Development server running (`php artisan serve`)
- [ ] Logged in as authenticated user

## 1. Page Access & Display

### Initial Load
- [ ] Can access `/admin/password-resets` (or configured route)
- [ ] Page loads without errors
- [ ] No 404 or 403 errors
- [ ] Page title/heading displays correctly
- [ ] Layout matches your application theme

### User List Table
- [ ] Table displays all users
- [ ] Columns visible: Checkbox, ID, Name, Email
- [ ] Users are sorted (usually by name)
- [ ] Table is responsive (check on mobile)
- [ ] "Total users" count displays correctly

## 2. User Selection

### Select All Functionality
- [ ] "Select All" checkbox in header works
- [ ] Checking "Select All" selects all users
- [ ] Unchecking "Select All" deselects all users
- [ ] Individual checkbox changes update "Select All" state

### Individual Selection
- [ ] Can select individual users
- [ ] Can deselect individual users
- [ ] Multiple users can be selected simultaneously
- [ ] Selected count is visible (if implemented)

## 3. Search & Filtering

### Search by Name
- [ ] Search input field is visible
- [ ] Typing a name filters users (e.g., "John")
- [ ] Results update in real-time or after button click
- [ ] Case-insensitive search works
- [ ] Partial matches work (e.g., "Joh" finds "John")

### Search by Email
- [ ] Can search by email address
- [ ] Partial email search works (e.g., "john@" finds "john@example.com")
- [ ] Results update correctly

### Clear Filters
- [ ] "Clear Filters" button works
- [ ] All filters reset when cleared
- [ ] Full user list displays after clearing

### Role Filtering (if applicable)
- [ ] Role filter input is visible
- [ ] Can filter by role name
- [ ] Results show only users with that role
- [ ] Works in combination with search

## 4. Password Reset - Show Method

### Single User Reset
- [ ] Select one user
- [ ] Choose "Show password on screen"
- [ ] Click "Reset Passwords"
- [ ] Success message appears
- [ ] Password table displays with User ID and Password
- [ ] Password is visible and can be copied
- [ ] Can login with the new password

### Multiple Users Reset
- [ ] Select 2-3 users
- [ ] Choose "Show password on screen"
- [ ] Submit form
- [ ] All passwords displayed in table
- [ ] Each user has unique password (unless custom used)
- [ ] Can copy individual passwords
- [ ] All users can login with their new passwords

### Password Display
- [ ] Passwords are clearly visible
- [ ] User IDs are correctly matched with passwords
- [ ] Table is well-formatted
- [ ] Warning message about saving passwords appears
- [ ] Passwords are not shown again after page refresh

## 5. Custom Password

### Custom Password Input
- [ ] Custom password field is visible
- [ ] Can enter custom password
- [ ] Minimum length validation works (8 characters)
- [ ] Error shows if password too short

### Custom Password Reset
- [ ] Enter custom password: "TestPass123!"
- [ ] Select multiple users
- [ ] Submit form
- [ ] All selected users get the same password
- [ ] Can login with custom password
- [ ] Password is correctly hashed in database

## 6. Email Notification

### Email Configuration
- [ ] Mail configured in `.env`
- [ ] Using Mailtrap or similar for testing
- [ ] Mail settings are correct

### Email Notification Test
- [ ] Select users
- [ ] Choose "Email users their new password"
- [ ] Submit form
- [ ] Success message appears
- [ ] Check email inbox
- [ ] Email received for each user
- [ ] Email contains new password
- [ ] Email has security warnings
- [ ] Email has login instructions
- [ ] Email mentions who initiated the reset

## 7. Form Validation

### Required Fields
- [ ] Cannot submit without selecting users
- [ ] Error message: "Please select at least one user"
- [ ] Cannot submit without notification method
- [ ] Error message appears for missing fields

### User ID Validation
- [ ] Cannot submit with invalid user ID
- [ ] Error message for non-existent user
- [ ] Form doesn't submit with invalid data

### Password Validation
- [ ] Custom password must be at least 8 characters
- [ ] Error message for short password
- [ ] Form validates before submission

### CSRF Protection
- [ ] Form includes CSRF token
- [ ] Cannot submit without valid token
- [ ] Token validation works

## 8. Error Handling

### No Users Selected
- [ ] Appropriate error message
- [ ] Form doesn't submit
- [ ] User can correct and retry

### Database Errors
- [ ] Graceful error handling
- [ ] User-friendly error messages
- [ ] Errors logged properly

### Network Issues
- [ ] Loading states visible (if implemented)
- [ ] Timeout handling
- [ ] Retry options

## 9. UI/UX

### Styling
- [ ] Matches application theme
- [ ] Bootstrap/Tailwind classes work
- [ ] Colors and fonts consistent
- [ ] Icons display correctly (if any)

### Responsiveness
- [ ] Works on desktop
- [ ] Works on tablet
- [ ] Works on mobile
- [ ] Table scrolls horizontally on small screens
- [ ] Buttons are touch-friendly

### User Experience
- [ ] Clear instructions visible
- [ ] Helpful tooltips (if any)
- [ ] Loading indicators (if any)
- [ ] Success/error messages are clear
- [ ] Navigation is intuitive

### Accessibility
- [ ] Keyboard navigation works
- [ ] Screen reader friendly (if applicable)
- [ ] Form labels are associated
- [ ] Color contrast is sufficient

## 10. Security

### Authentication
- [ ] Unauthenticated users redirected to login
- [ ] Only authenticated users can access
- [ ] Session persists correctly

### Authorization (if implemented)
- [ ] Only authorized users can reset passwords
- [ ] Role/permission checks work
- [ ] Unauthorized access is blocked

### Data Protection
- [ ] Passwords not logged in plain text
- [ ] CSRF protection active
- [ ] XSS protection works
- [ ] SQL injection protection

## 11. Logging

### Log Entries
- [ ] Password resets are logged
- [ ] Log includes user ID
- [ ] Log includes initiator
- [ ] Log includes timestamp
- [ ] Can view logs: `tail -f storage/logs/laravel.log`

## 12. Performance

### Page Load
- [ ] Page loads quickly (< 2 seconds)
- [ ] No excessive database queries
- [ ] Assets load properly

### Large User Lists
- [ ] Handles 100+ users (if applicable)
- [ ] Pagination works (if implemented)
- [ ] Search is fast

## Test Results Summary

**Date:** _______________
**Tester:** _______________
**Laravel Version:** _______________
**Package Version:** _______________

**Total Tests:** _____
**Passed:** _____
**Failed:** _____

### Issues Found:
1. _________________________________
2. _________________________________
3. _________________________________

### Notes:
_________________________________
_________________________________
_________________________________

