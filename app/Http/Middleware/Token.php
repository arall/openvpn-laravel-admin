<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class Token
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $token = $request->bearerToken();
        if ($token !== getenv('API_TOKEN')) {
            return abort(403);
        }

        return $next($request);
    }
}
