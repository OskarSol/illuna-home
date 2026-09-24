<?php

return [
    'registration_enabled' => (bool) env('ILLUNA_REGISTRATION_ENABLED', false),
    'beta_invite_code' => env('ILLUNA_BETA_INVITE_CODE'),
    'noindex' => (bool) env('ILLUNA_NOINDEX', true),
    // Configure the account-only endpoint on the server; never publish it in source.
    // Public examples always use a placeholder.
    'api_url' => env('ILLUNA_API_URL'),
    'plans' => [
        'free' => [
            'name' => 'Free',
            'monthly_price_cents' => 0,
            'label_adaptions' => 1_000,
            'full_adaptions' => 0,
            'description' => 'Find the right words for every user.',
            'features' => ['Translations, language and tone', 'Text-label changes only', 'Your own API key'],
        ],
        'beta' => [
            'name' => 'Beta',
            'monthly_price_cents' => 990,
            'label_adaptions' => 1_000,
            'full_adaptions' => 500,
            'description' => 'Make the whole experience feel personal.',
            'features' => ['Everything in Free', 'Design, layout, themes and icons', 'Accessibility, visibility and labels'],
        ],
    ],
    // Displayed pricing only; checkout and usage enforcement are not connected.
    'additional_adaptions' => [
        'full_adaptions' => 1_000,
        'price_cents' => 1_000,
        'requires_plan' => 'beta',
    ],
];
