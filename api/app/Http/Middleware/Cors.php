<?php

namespace App\Http\Middleware;

use Closure;

class Cors {
    public function handle($request, Closure $next)
    {
        if ($_SERVER['HTTP_ORIGIN'] == 'https://mhmaphelper.agiletravels.com') {
            return $next($request)
                ->header('Access-Control-Allow-Origin', '*')
                ->header('Access-Control-Allow-Methods', 'GET');
        } else {
            return $next($request);
        }
    }
}
