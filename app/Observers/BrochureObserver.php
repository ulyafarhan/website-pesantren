<?php

declare(strict_types=1);

namespace App\Observers;

use App\Models\Brochure;
use Illuminate\Support\Facades\Cache;

class BrochureObserver
{
    /**
     * Dipanggil setelah CREATE atau UPDATE berhasil.
     * Brosur hanya muncul di API endpoint dan halaman download (jika ada).
     */
    public function saved(Brochure $brochure): void
    {
        Cache::forget('api_brochures');
    }

    /**
     * Dipanggil setelah DELETE.
     */
    public function deleted(Brochure $brochure): void
    {
        Cache::forget('api_brochures');
    }

    /**
     * Dipanggil setelah RESTORE (jika menggunakan SoftDeletes di masa depan).
     */
    public function restored(Brochure $brochure): void
    {
        $this->deleted($brochure);
    }

    /**
     * Dipanggil setelah FORCE DELETE.
     */
    public function forceDeleted(Brochure $brochure): void
    {
        $this->deleted($brochure);
    }
}