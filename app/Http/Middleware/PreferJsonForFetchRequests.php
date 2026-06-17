<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Browser fetch()/XHR without Accept: application/json still needs machine-readable
 * error responses. Without this, Laravel redirects (302) and fetch follows them as 200 HTML.
 */
class PreferJsonForFetchRequests
{
    public function handle(Request $request, Closure $next): Response
    {
        if (! $request->expectsJson() && $this->isFetchLikeRequest($request)) {
            $request->headers->set('Accept', 'application/json');
        }

        return $next($request);
    }

    private function isFetchLikeRequest(Request $request): bool
    {
        return in_array($request->header('Sec-Fetch-Mode'), ['cors', 'same-origin'], true)
            && $request->header('Sec-Fetch-Dest') === 'empty';
    }
}
