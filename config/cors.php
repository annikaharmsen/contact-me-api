<?php
// config/cors.php

return [
    'paths' => ['api/*'],

    'allowed_methods' => ['*'],

    'allowed_origins' => [
        'https://' . env('REQUEST_DOMAIN'),     // Production frontend
        'https://www.' . env('REQUEST_DOMAIN'), // WWW alias
    ],

    'allowed_headers' => ['*'],

    'exposed_headers' => [],

    'max_age' => 3600,

    'supports_credentials' => false,
];
