<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Symfony\Component\HttpFoundation\Response;

class FullPageCache
{
    /**
     * Handle an incoming request.
     * * Default TTL: 24 Jam (86400 detik)
     */
    public function handle(Request $request, Closure $next, int $ttl = 86400): Response
    {
        // 1. JANGAN Cache rute dokumentasi API atau Scribe
        if ($request->is('docs*') || $request->routeIs('scribe.*')) {
            return $next($request);
        }

        // 2. HANYA Cache method GET
        if (! $request->isMethod('GET')) {
            return $next($request);
        }

        // 3. JANGAN Cache jika user sedang login (Admin/Filament) atau request Livewire
        if (Auth::check() || $request->is('admin*') || $request->is('livewire*')) {
            return $next($request);
        }

        // 4. JANGAN Cache jika request ke folder storage (Mencegah loop 404 gambar)
        if ($request->is('storage/*')) {
            return $next($request);
        }

        // Generate Key unik berdasarkan URL lengkap (termasuk query string)
        $key = 'page_cache_' . md5($request->fullUrl());

        // 5. CEK CACHE: Jika ada, langsung kembalikan respons statis
        if (Cache::has($key)) {
            $cachedContent = Cache::get($key);
            
            return response($cachedContent)
                ->header('Content-Type', 'text/html')
                ->header('X-Cache', 'HIT');
        }

        // 6. LANJUTKAN REQUEST: Ambil respons dari server
        $response = $next($request);

        // 7. VALIDASI SEBELUM SIMPAN: Hanya cache jika HTTP 200, bukan AJAX, dan respons sukses
        if ($this->shouldCache($request, $response)) {
            Cache::put($key, $response->getContent(), $ttl);
            $response->headers->set('X-Cache', 'MISS');
        }

        return $response;
    }

    /**
     * Menentukan apakah respons layak untuk disimpan di cache.
     */
    private function shouldCache(Request $request, Response $response): bool
    {
        return $response->getStatusCode() === 200 
            && ! $request->ajax() 
            && method_exists($response, 'getContent');
    }
}