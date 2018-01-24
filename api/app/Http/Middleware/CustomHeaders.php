<?php

namespace App\Http\Middleware;

use Closure;

class CustomHeaders {
    public function handle($request, Closure $next)
    {
        $response = $next($request);
        $response->header('Content-Length', strlen($response->getContent()));
        return $response;
    }
}
