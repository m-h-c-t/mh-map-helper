<?php

namespace App\Http\Middleware;

use Closure;

class Cors {
    public function handle($request, Closure $next)
    {
        $url = explode('.', $_SERVER['HTTP_HOST']);
        if ($_SERVER['HTTP_ORIGIN'] == 'https://' . implode('.', [$url[1], $url[2], $url[3]])) {
            return $next($request)
                ->header('Access-Control-Allow-Origin', '*')
                ->header('Access-Control-Allow-Methods', 'GET');
        } else {
            return $next($request);
        }
    }
}
