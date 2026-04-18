<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class FullPageCache
{
    /**
     * Handle an incoming request.
     * * PERUBAHAN ARSITEKTUR: Middleware ini tidak lagi membebani database/disk lokal
     * untuk menyimpan HTML. Sebaliknya, ia menyuntikkan HTTP Cache-Control Headers.
     * * Di produksi (Fase 5.4), Cloudflare Edge akan membaca header ini dan menahan trafik
     * sebelum mencapai server cPanel Anda. Ini adalah inti dari "Highly Available".
     */
    public function handle(Request $request, Closure $next, int $ttl = 86400): Response
    {
        // Lanjutkan request untuk mengambil respons
        $response = $next($request);

        // Abaikan request jika bukan GET, AJAX, atau jika tidak sukses
        if (!$request->isMethod('GET') || $request->ajax() || $response->getStatusCode() !== 200) {
            return $response;
        }

        // Jangan pernah melakukan cache pada halaman yang sensitif (Formulir PPDB, Kontak, Admin, Scribe)
        if ($request->is('ppdb*') || $request->is('contact*') || $request->is('admin*') || $request->is('livewire*') || $request->is('docs*') || $request->routeIs('scribe.*')) {
            // Instruksikan proxy (seperti Cloudflare) dan browser untuk SELALU meminta versi terbaru
            $response->headers->set('Cache-Control', 'no-store, no-cache, must-revalidate, max-age=0');
            $response->headers->set('Pragma', 'no-cache');
            return $response;
        }

        // Jangan cache jika pengguna sedang login
        if (Auth::check()) {
            return $response;
        }

        // JIKA HALAMAN AMAN DARI FORMULIR (Artikel, Galeri, Profil):
        // Suntikkan header Cache-Control agar Cloudflare menangkapnya (Fase 5 Project Brief)
        $response->headers->set('Cache-Control', "public, max-age={$ttl}");

        return $response;
    }
}