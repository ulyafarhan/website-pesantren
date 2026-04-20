<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;

class ClearPublicCache extends Command
{
    /**
     * Nama perintah yang akan diketik di terminal
     */
    protected $signature = 'cache:public-clear';

    /**
     * Deskripsi perintah
     */
    protected $description = 'Clear all strictly defined public-facing page caches without wiping system cache';

    /**
     * Eksekusi perintah
     */
    public function handle(): void
    {
        // Daftar semua kunci cache (Cache Keys) yang Anda definisikan di sistem
        $keys = [
            'site_settings_global', 
            'api_site_settings',
            'api_articles', 
            'home_articles', 
            'api_galleries',
            'home_galleries', 
            'api_facilities', 
            'home_facilities',
            'api_class_programs', 
            'home_programs',
            'api_testimonials', 
            'home_testimonials',
            'api_brochures', 
            'api_active_period',
            'active_registration_period', 
            'dashboard_stats',
        ];

        $clearedCount = 0;

        $this->components->info('Mulai membersihkan public cache...');

        foreach ($keys as $key) {
            if (Cache::has($key)) {
                Cache::forget($key);
                $clearedCount++;
                $this->components->task("Clearing cache key: {$key}");
            }
        }

        // Jika Anda juga menggunakan Full Page Cache (Middleware) dengan response disk
        // Anda bisa menambahkan logika penghapusan folder /storage/app/cache di sini (opsional)

        if ($clearedCount > 0) {
            $this->components->info("Berhasil! {$clearedCount} kunci cache publik telah dihapus.");
        } else {
            $this->components->warn("Tidak ada cache publik yang perlu dihapus (sudah kosong).");
        }
    }
}