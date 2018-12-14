<?php

namespace App\Http\Middleware;

use Closure;

class ReleaseIdentifier
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $release = env("RELEASE_IDENTIFIER", "");
        $response = $next($request);
        return $response->header('Release-Identifier', $release);
    }
}
