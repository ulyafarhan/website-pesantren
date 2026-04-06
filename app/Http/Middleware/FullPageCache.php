<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Symfony\Component\HttpFoundation\Response;

class FullPageCache
{
    public function handle(Request $request, Closure $next, int $ttl = 86400): Response
    {
        if ($request->is('docs*') || $request->routeIs('scribe.*')) {
            return $next($request);
        }

        if (! $request->isMethod('GET')) {
            return $next($request);
        }

        // PENTING: Pengecekan admin* tidak boleh dibungkus Auth::check(). 
        // Jika dibungkus, halaman login (/admin/login) akan ikut tercache oleh guest, 
        // sehingga CSRF Token menjadi statis/basi dan menyebabkan infinite login loop (419 Page Expired).
        if (Auth::check() || $request->is('admin*') || $request->is('livewire*')) {
            return $next($request);
        }

        $key = 'page_' . md5($request->fullUrl());

        if (Cache::has($key)) {
            $cachedResponse = response(Cache::get($key));
            $cachedResponse->headers->set('X-Cache', 'HIT');
            return $cachedResponse;
        }

        $response = $next($request);

        if ($response->getStatusCode() === 200 && method_exists($response, 'getContent')) {
            Cache::put($key, $response->getContent(), $ttl);
        }

        $response->headers->set('X-Cache', 'MISS');

        return $response;
    }
}