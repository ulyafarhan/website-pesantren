<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PublicController;
use App\Http\Middleware\FullPageCache;

/**
 * Rute Publik dengan Proteksi Trafik Tinggi (Full Page Caching)
 */
Route::middleware([FullPageCache::class])->group(function () {
    
    Route::get('/', [PublicController::class, 'index'])->name('home');

    // Berita & Artikel
    Route::prefix('berita')->name('articles.')->group(function () {
        Route::get('/', [PublicController::class, 'articles'])->name('index');
        Route::get('/{slug}', [PublicController::class, 'articleShow'])->name('show');
    });

    // Menu Lainnya
    Route::get('/fasilitas', [PublicController::class, 'facilities'])->name('facilities.index');
    Route::get('/galeri', [PublicController::class, 'galleries'])->name('galleries.index');
    Route::get('/program', [PublicController::class, 'programs'])->name('programs.index');
    Route::get('/testimoni', [PublicController::class, 'testimonials'])->name('testimonials.index');

    // PPDB Online
    Route::prefix('ppdb')->name('ppdb.')->group(function () {
        Route::get('/daftar', [PublicController::class, 'ppdbRegister'])->name('register');
        Route::get('/status', [PublicController::class, 'ppdbStatus'])->name('status'); // Tambah ini
        Route::get('/success', [PublicController::class, 'ppdbSuccess'])->name('success');
    });
});