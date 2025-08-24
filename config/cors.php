<?php

return [
    'paths' => ['api', 'api/*'],

    'allowed_methods' => ['POST', 'GET'],

    'allowed_origins' => [
        'https://' . env('REQUEST_DOMAIN'),     // Production frontend
        'https://www.' . env('REQUEST_DOMAIN'), // WWW alias
    ],

    'allowed_headers' => ['*'],

    'exposed_headers' => [],

    'max_age' => 3600, // 1 hour

    'supports_credentials' => false,
];
