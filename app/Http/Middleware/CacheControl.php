<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CacheControl
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle($request, Closure $next)
    {
        $response = $next($request);
        
        // Hanya cache halaman publik (bukan admin/login)
        if (!$request->is('admin*') && 
            !$request->is('login*') && 
            $request->isMethod('GET')) {
            $response->headers->set(
                'Cache-Control', 
                'public, max-age=300, s-maxage=3600'
            );
        }
        
        return $response;
    }
}
