<?php

// config for Rutul/MassUsersPasswordReset
return [
    /*
     * Route configuration
     */
    'route' => [
        'prefix' => 'admin/password-resets',
        'middleware' => ['web', 'auth'],
    ],

    // Default layout to extend
    'layout' => 'layouts.app',
    
    // Section to inject content into
    'section' => 'content',
    
    // Default password length for generated passwords
    'password_length' => 12,
    
    // Minimum password length
    'password_min_length' => 8,
    
    // Enable logging of password reset operations
    'enable_logging' => true,
    
    // User model class (will use default auth provider if not set)
    'user_model' => null,
];
