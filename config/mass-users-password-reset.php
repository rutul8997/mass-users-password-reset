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
    
    // Default password length
    'password_length' => 12,
];
