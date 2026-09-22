<?php

return [
    'registration_enabled' => (bool) env('ILLUNA_REGISTRATION_ENABLED', false),
    'beta_invite_code' => env('ILLUNA_BETA_INVITE_CODE'),
    'noindex' => (bool) env('ILLUNA_NOINDEX', true),
];
