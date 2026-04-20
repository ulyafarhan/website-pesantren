<?php

declare(strict_types=1);

namespace App\Observers;

use App\Models\Facility;
use Illuminate\Support\Facades\Cache;

class FacilityObserver
{
    /**
     * Dipanggil setelah CREATE atau UPDATE berhasil.
     * Fasilitas muncul di halaman beranda (hero section) dan halaman /fasilitas.
     */
    public function saved(Facility $facility): void
    {
        // Cache halaman publik beranda & halaman fasilitas
        Cache::forget('home_facilities');
        Cache::forget('page_facilities');

        // Cache API endpoint
        Cache::forget('api_facilities');

        // Cache dashboard admin (stats widget)
        Cache::forget('dashboard_stats');
    }

    /**
     * Dipanggil setelah DELETE.
     */
    public function deleted(Facility $facility): void
    {
        Cache::forget('home_facilities');
        Cache::forget('page_facilities');
        Cache::forget('api_facilities');
        Cache::forget('dashboard_stats');
    }

    /**
     * Dipanggil setelah RESTORE (jika menggunakan SoftDeletes di masa depan).
     */
    public function restored(Facility $facility): void
    {
        $this->deleted($facility);
    }

    /**
     * Dipanggil setelah FORCE DELETE.
     */
    public function forceDeleted(Facility $facility): void
    {
        $this->deleted($facility);
    }
}