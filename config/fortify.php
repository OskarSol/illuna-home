<?php

use Laravel\Fortify\Features;

return [
    'guard' => 'web',
    'passwords' => 'users',
    'username' => 'email',
    'email' => 'email',
    'lowercase_usernames' => true,
    'home' => '/dashboard',
    'prefix' => '',
    'domain' => null,
    'middleware' => ['web', 'auth.session'],
    'auth_middleware' => 'auth',
    'limiters' => ['login' => 'login'],
    'views' => true,
    'features' => array_values(array_filter([
        env('ILLUNA_REGISTRATION_ENABLED', false) ? Features::registration() : null,
        Features::resetPasswords(),
        Features::emailVerification(),
        Features::updateProfileInformation(),
        Features::updatePasswords(),
    ])),
];
