<?php

declare(strict_types=1);

namespace App\Observers;

use App\Models\Testimonial;
use Illuminate\Support\Facades\Cache;

class TestimonialObserver
{
    /**
     * Dipanggil setelah CREATE atau UPDATE berhasil.
     *
     * Skenario umum: admin toggle `is_active` dari Filament ToggleColumn.
     * Jika testimonial diaktifkan/dinonaktifkan, cache harus segera di-hapus
     * agar perubahan terlihat tanpa menunggu 12 jam TTL berakhir.
     */
    public function saved(Testimonial $testimonial): void
    {
        // Cache testimoni di beranda
        Cache::forget('home_testimonials');

        // Cache API endpoint /api/v1/testimonials
        Cache::forget('api_testimonials');
    }

    /**
     * Dipanggil setelah DELETE.
     */
    public function deleted(Testimonial $testimonial): void
    {
        Cache::forget('home_testimonials');
        Cache::forget('api_testimonials');
    }

    /**
     * Dipanggil setelah RESTORE (jika menggunakan SoftDeletes di masa depan).
     */
    public function restored(Testimonial $testimonial): void
    {
        $this->deleted($testimonial);
    }

    /**
     * Dipanggil setelah FORCE DELETE.
     */
    public function forceDeleted(Testimonial $testimonial): void
    {
        $this->deleted($testimonial);
    }
}