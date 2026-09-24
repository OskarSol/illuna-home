<?php

return [
    // Application Insights Query API (also for workspace-backed resources).
    'app_id' => env('ILLUNA_ANALYTICS_APP_ID'),
    'webhook_url' => env('ILLUNA_ANALYTICS_WEBHOOK_URL'),
    'tenant_id' => env('ILLUNA_ANALYTICS_TENANT_ID'),
    'client_id' => env('ILLUNA_ANALYTICS_CLIENT_ID'),
    'client_secret' => env('ILLUNA_ANALYTICS_CLIENT_SECRET'),
];
