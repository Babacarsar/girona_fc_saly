<?php

$cloudName = env('CLOUDINARY_CLOUD_NAME');
$apiKey = env('CLOUDINARY_API_KEY', env('CLOUDINARY_KEY'));
$apiSecret = env('CLOUDINARY_API_SECRET', env('CLOUDINARY_SECRET'));

$cloudUrl = env('CLOUDINARY_URL');
if (! $cloudUrl && $cloudName && $apiKey && $apiSecret) {
    $cloudUrl = sprintf('cloudinary://%s:%s@%s', $apiKey, $apiSecret, $cloudName);
}

return [

    /*
    |--------------------------------------------------------------------------
    | Configuration Cloudinary
    |--------------------------------------------------------------------------
    |
    | Le SDK Laravel attend surtout cloud_url (CLOUDINARY_URL ou les 3 variables).
    |
    */

    'notification_url' => env('CLOUDINARY_NOTIFICATION_URL'),

    'cloud_url' => $cloudUrl,

    'cloud_name' => $cloudName,

    'api_key' => $apiKey,

    'api_secret' => $apiSecret,

    'upload_preset' => env('CLOUDINARY_UPLOAD_PRESET'),

    'secure' => true,
];
