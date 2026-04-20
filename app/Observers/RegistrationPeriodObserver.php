<?php

declare(strict_types=1);

namespace App\Observers;

use App\Models\RegistrationPeriod;
use Illuminate\Support\Facades\Cache;

class RegistrationPeriodObserver
{
    /**
     * Dipanggil setelah CREATE atau UPDATE berhasil.
     *
     * Skenario kritis: admin mengaktifkan/menonaktifkan gelombang pendaftaran.
     * Cache `active_registration_period` dan `api_active_period` wajib langsung
     * di-invalidasi agar halaman /ppdb/daftar dan API segera menampilkan status terbaru.
     */
    public function saved(RegistrationPeriod $registrationPeriod): void
    {
        // Cache periode aktif — dipakai di halaman PPDB publik
        Cache::forget('active_registration_period');

        // Cache API endpoint periode aktif
        Cache::forget('api_active_period');

        // Cache dashboard admin (stats widget & jumlah pendaftar)
        Cache::forget('dashboard_stats');
    }

    /**
     * Dipanggil setelah DELETE.
     * Jika gelombang yang aktif dihapus, halaman PPDB harus langsung menampilkan
     * "pendaftaran ditutup" — bukan data gelombang lama dari cache.
     */
    public function deleted(RegistrationPeriod $registrationPeriod): void
    {
        Cache::forget('active_registration_period');
        Cache::forget('api_active_period');
        Cache::forget('dashboard_stats');
    }

    /**
     * Dipanggil setelah RESTORE (jika menggunakan SoftDeletes di masa depan).
     */
    public function restored(RegistrationPeriod $registrationPeriod): void
    {
        $this->deleted($registrationPeriod);
    }

    /**
     * Dipanggil setelah FORCE DELETE.
     */
    public function forceDeleted(RegistrationPeriod $registrationPeriod): void
    {
        $this->deleted($registrationPeriod);
    }
}