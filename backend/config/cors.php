<?php

return [
    'paths' => ['api/*', 'sanctum/csrf-cookie'],
    'allowed_methods' => ['*'],
    'allowed_origins' => [
        'http://localhost:8080',
        'https://*.github.io',
        env('FRONTEND_URL', 'http://localhost:8080'),
        'https://www.rrragainis.lv',
        'https://rrragainis.lv',
        'http://46.101.117.113',
        'http://[2a03:b0c0:3:f0::f2df:8000]',
        'http://10.114.0.2',
        'http://129.212.142.67',
    ],
    'allowed_origins_patterns' => [],
    'allowed_headers' => ['*'],
    'exposed_headers' => [],
    'max_age' => 0,
    'supports_credentials' => true,
]; 