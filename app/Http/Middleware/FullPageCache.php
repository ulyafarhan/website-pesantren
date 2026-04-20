<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class FullPageCache
{
    public function handle(Request $request, Closure $next, int $ttl = 86400): Response
    {
        $response = $next($request);

        if (!$request->isMethod('GET') || $request->ajax() || $response->getStatusCode() !== 200) {
            return $response;
        }

        // Penting: Gabungkan pengecekan state & route dalam satu blok eksekusi
        if ($request->is('ppdb*', 'contact*', 'admin*', 'livewire*', 'docs*') || $request->routeIs('scribe.*') || Auth::check()) {
            $response->headers->set('Cache-Control', 'no-store, no-cache, must-revalidate, max-age=0');
            $response->headers->set('Pragma', 'no-cache');
            return $response;
        }

        $response->headers->set('Cache-Control', "public, max-age={$ttl}");

        return $response;
    }
}