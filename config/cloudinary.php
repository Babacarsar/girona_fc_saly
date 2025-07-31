<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Configuration Cloudinary
    |--------------------------------------------------------------------------
    |
    | Ces variables sont chargées automatiquement à partir du fichier .env
    | (ou des variables Railway en production). Elles permettent à Cloudinary
    | de fonctionner avec ton application.
    |
    */

    'cloud_name' => env('CLOUDINARY_CLOUD_NAME'),

    'api_key'    => env('CLOUDINARY_API_KEY'),

    'api_secret' => env('CLOUDINARY_API_SECRET'),

    'secure'     => true,
];
