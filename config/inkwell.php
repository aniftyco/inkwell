<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Async Processing
    |--------------------------------------------------------------------------
    |
    | Configure how Inkwell handles heavy operations like email sending,
    | webhook processing, and cleanup tasks.
    |
    | Supported drivers: "terminate", "queue"
    |
    | - terminate: Work runs after HTTP response is sent (single-process friendly)
    | - queue: Traditional Laravel queue for scaled deployments
    |
    */

    'async' => [
        'driver' => env('INKWELL_ASYNC_DRIVER', 'terminate'),
        'queue' => env('INKWELL_QUEUE', 'default'),
    ],

    /*
    |--------------------------------------------------------------------------
    | Cleanup Configuration
    |--------------------------------------------------------------------------
    |
    | Configure automatic cleanup of soft-deleted records.
    |
    */

    'cleanup' => [
        'unsubscribed_after_days' => 30,
        'soft_deleted_after_days' => 90,
    ],

    /*
    |--------------------------------------------------------------------------
    | Theme Configuration
    |--------------------------------------------------------------------------
    |
    | Configure where themes are stored.
    |
    */

    'themes' => [
        'path' => base_path('themes'),
    ],

    /*
    |--------------------------------------------------------------------------
    | Dashboard Configuration
    |--------------------------------------------------------------------------
    |
    | Configure the Inkwell dashboard.
    |
    */

    'dashboard' => [
        'path' => 'inkwell',
        'middleware' => ['web', 'auth'],
    ],
];
