<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PortalHeaders
{
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);
        $response->headers->set('X-Content-Type-Options', 'nosniff');
        $response->headers->set('X-Frame-Options', 'SAMEORIGIN');
        $response->headers->set('Referrer-Policy', 'strict-origin-when-cross-origin');

        if (config('illuna.noindex')) {
            $response->headers->set('X-Robots-Tag', 'noindex, nofollow');
        }

        // The landing navigation is session-aware too; do not share cached pages.
        $response->headers->set('Cache-Control', 'no-store, private');

        return $response;
    }
}
