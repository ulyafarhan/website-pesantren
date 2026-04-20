<?php

declare(strict_types=1);

namespace App\Observers;

use App\Models\Gallery;
use Illuminate\Support\Facades\Cache;

class GalleryObserver
{
    /**
     * Dipanggil setelah CREATE atau UPDATE berhasil.
     * Galeri muncul di beranda (6 foto) dan halaman /galeri (semua foto, paginasi).
     *
     * CATATAN: Halaman /galeri menggunakan simplePaginate() tanpa cache karena
     * paginasi tidak bisa di-cache (link page berubah). Hanya beranda yang perlu
     * di-invalidasi karena menggunakan Cache::remember().
     */
    public function saved(Gallery $gallery): void
    {
        // Cache galeri di beranda
        Cache::forget('home_galleries');

        // Cache API endpoint
        Cache::forget('api_galleries');

        // Cache dashboard admin (stats widget)
        Cache::forget('dashboard_stats');
    }

    /**
     * Dipanggil setelah DELETE.
     */
    public function deleted(Gallery $gallery): void
    {
        Cache::forget('home_galleries');
        Cache::forget('api_galleries');
        Cache::forget('dashboard_stats');
    }

    /**
     * Dipanggil setelah RESTORE (jika menggunakan SoftDeletes di masa depan).
     */
    public function restored(Gallery $gallery): void
    {
        $this->deleted($gallery);
    }

    /**
     * Dipanggil setelah FORCE DELETE.
     */
    public function forceDeleted(Gallery $gallery): void
    {
        $this->deleted($gallery);
    }
}