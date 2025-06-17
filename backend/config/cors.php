<?php

return [
    'paths' => ['api/*', 'sanctum/csrf-cookie'],
    'allowed_methods' => ['*'],
    'allowed_origins' => ['*'],
    'allowed_origins_patterns' => [],
    'allowed_headers' => ['X-Requested-With', 'Content-Type', 'Accept', 'Authorization', 'X-CSRF-TOKEN'],
    'exposed_headers' => ['*'],
    'max_age' => 1728000, // 20 days
    'supports_credentials' => true,
]; 