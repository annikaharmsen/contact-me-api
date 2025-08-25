<?php

return [
    'paths' => ['api', 'api/*'],

    'allowed_methods' => ['POST', 'OPTIONS'],

    'allowed_origins' => [
        'https://' . env('REQUEST_DOMAIN'),     // Production frontend (https)
        'https://www.' . env('REQUEST_DOMAIN'), // WWW alias (https)
        'http://' . env('REQUEST_DOMAIN'),     // Production frontend (http)
        'http://www.' . env('REQUEST_DOMAIN'), // WWW alias (http)
    ],

    'allowed_headers' => ['*'],

    'exposed_headers' => [],

    'max_age' => 3600, // 1 hour

    'supports_credentials' => false,
];
