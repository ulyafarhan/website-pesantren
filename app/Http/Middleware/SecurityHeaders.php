<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SecurityHeaders
{
    /**
     * Handle an incoming request & attach security headers.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        // Pastikan respons memiliki properti 'headers' (Instance dari Symfony ResponseHeaderBag)
        // Ini aman untuk semua tipe respons, termasuk BinaryFileResponse (Download File)
        if (property_exists($response, 'headers')) {
            
            // Mencegah browser menebak MIME type (Mencegah eksekusi file berbahaya yang disamarkan)
            $response->headers->set('X-Content-Type-Options', 'nosniff');
            
            // Mencegah Clickjacking (Website tidak bisa di-embed di dalam iframe web orang lain)
            $response->headers->set('X-Frame-Options', 'SAMEORIGIN');
            
            // Mengaktifkan filter XSS bawaan untuk browser lama (meski browser modern sudah meninggalkannya)
            $response->headers->set('X-XSS-Protection', '1; mode=block');
            
            // Memaksa browser selalu menggunakan HTTPS selama 1 tahun, termasuk untuk semua subdomain
            // Penambahan 'preload' sangat baik jika domain Anda didaftarkan di hstspreload.org
            $response->headers->set('Strict-Transport-Security', 'max-age=31536000; includeSubDomains; preload');
            
            // Menjaga privasi URL (menghindari kebocoran token/parameter URL) saat user klik link keluar
            $response->headers->set('Referrer-Policy', 'strict-origin-when-cross-origin');
            
            // Memblokir akses API perangkat keras yang tidak diperlukan oleh website pesantren
            $response->headers->set('Permissions-Policy', 'geolocation=(), microphone=(), camera=()');
            
            // Content-Security-Policy (CSP) sengaja tidak diaktifkan secara agresif 
            // agar tidak merusak eksekusi JavaScript dinamis bawaan Livewire/Filament Admin.
        }

        return $response;
    }
}