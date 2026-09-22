<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Routing\Middleware\ThrottleRequests;
use Symfony\Component\HttpFoundation\Response;

class ThrottleAccountActions
{
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->routeIs('register', 'register.store')) {
            abort_unless(config('illuna.registration_enabled'), 404);
        }

        if ($request->routeIs(
            'register.store', 'password.email', 'password.update',
            'user-profile-information.update', 'user-password.update', 'password.confirm.store'
        )) {
            return app(ThrottleRequests::class)->handle($request, $next, 'account-actions');
        }

        return $next($request);
    }
}
