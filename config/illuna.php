<?php

return [
    'registration_enabled' => (bool) env('ILLUNA_REGISTRATION_ENABLED', false),
    'beta_invite_code' => env('ILLUNA_BETA_INVITE_CODE'),
    'noindex' => (bool) env('ILLUNA_NOINDEX', true),
    // Configure the account-only endpoint on the server; never publish it in source.
    // Public examples always use a placeholder.
    'api_url' => env('ILLUNA_API_URL'),
    'plans' => [
        'beta' => [
            'name' => 'Beta',
            'token_limit' => 1_000_000,
            'price_per_million_cents' => 0,
            'available' => true,
        ],
        'usage' => [
            'name' => 'Usage-based',
            'token_limit' => null,
            'price_per_million_cents' => 1_000,
            'available' => false,
        ],
    ],
];
