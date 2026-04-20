<?php

declare(strict_types=1);

namespace App\Observers;

use App\Models\SiteSetting;
use Illuminate\Support\Facades\Cache;

class SiteSettingObserver
{
    /**
     * Dipanggil setelah CREATE atau UPDATE berhasil.
     *
     * SiteSetting adalah data paling global: nama pesantren, logo, kontak, dll.
     * Muncul di SETIAP halaman via View::composer dan di semua response API.
     * Setiap perubahan apapun (bahkan update nomor telepon) harus langsung
     * terlihat tanpa menunggu TTL cache berakhir.
     */
    public function saved(SiteSetting $siteSetting): void
    {
        $this->flushAllCaches();
    }

    /**
     * Dipanggil setelah DELETE.
     * Sangat jarang terjadi karena SiteSetting biasanya singleton (1 row),
     * tapi tetap kita tangani untuk konsistensi.
     */
    public function deleted(SiteSetting $siteSetting): void
    {
        $this->flushAllCaches();
    }

    /**
     * Dipanggil setelah RESTORE (jika menggunakan SoftDeletes di masa depan).
     */
    public function restored(SiteSetting $siteSetting): void
    {
        $this->flushAllCaches();
    }

    /**
     * Dipanggil setelah FORCE DELETE.
     */
    public function forceDeleted(SiteSetting $siteSetting): void
    {
        $this->flushAllCaches();
    }

    // ─── Private Helpers ───────────────────────────────────────────────────────

    /**
     * Hapus semua cache yang berisi data SiteSetting.
     * Dipanggil dari semua event agar tidak ada duplikasi kode.
     */
    private function flushAllCaches(): void
    {
        // Cache View::composer (AppServiceProvider) — muncul di semua halaman publik
        Cache::forget('site_settings_global');

        // Cache API endpoint /api/v1/settings
        Cache::forget('api_site_settings');

        // Cache lama yang mungkin masih tersimpan dari controller versi sebelumnya
        Cache::forget('site_settings');
    }
}