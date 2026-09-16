<?php

$frontendUrls = env('FRONTEND_URLS');

return [

    /*
    |--------------------------------------------------------------------------
    | Cross-Origin Resource Sharing (CORS) Configuration
    |--------------------------------------------------------------------------
    |
    | FRONTEND_URLS: comma-separated origins (e.g. https://www.example.com,http://localhost:8080).
    | Leave empty to allow all origins (*).
    |
    */

    'paths' => ['api/*', 'sanctum/csrf-cookie'],

    'allowed_methods' => ['*'],

    'allowed_origins' => $frontendUrls
        ? array_values(array_filter(array_map('trim', explode(',', $frontendUrls))))
        : ['*'],

    'allowed_origins_patterns' => [],

    'allowed_headers' => ['*'],

    'exposed_headers' => [],

    'max_age' => 0,

    'supports_credentials' => false,

];
