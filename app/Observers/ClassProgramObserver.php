<?php

declare(strict_types=1);

namespace App\Observers;

use App\Models\ClassProgram;
use Illuminate\Support\Facades\Cache;

class ClassProgramObserver
{
    /**
     * Dipanggil setelah CREATE atau UPDATE berhasil.
     * Program kelas di-cache permanen (rememberForever), jadi wajib
     * di-invalidasi manual setiap kali admin melakukan perubahan.
     */
    public function saved(ClassProgram $classProgram): void
    {
        // Cache halaman publik /program
        Cache::forget('home_programs');
        Cache::forget('page_programs');

        // Cache API endpoint
        Cache::forget('api_class_programs');

        // Cache dashboard admin (stats widget)
        Cache::forget('dashboard_stats');
    }

    /**
     * Dipanggil setelah DELETE.
     */
    public function deleted(ClassProgram $classProgram): void
    {
        Cache::forget('home_programs');
        Cache::forget('page_programs');
        Cache::forget('api_class_programs');
        Cache::forget('dashboard_stats');
    }

    /**
     * Dipanggil setelah RESTORE (jika menggunakan SoftDeletes di masa depan).
     */
    public function restored(ClassProgram $classProgram): void
    {
        $this->deleted($classProgram);
    }

    /**
     * Dipanggil setelah FORCE DELETE.
     */
    public function forceDeleted(ClassProgram $classProgram): void
    {
        $this->deleted($classProgram);
    }
}