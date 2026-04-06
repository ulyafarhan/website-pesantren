<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PublicController;

// Halaman Beranda
Route::get('/', [PublicController::class, 'index'])->name('home');

// Halaman Berita & Artikel
Route::get('/berita', [PublicController::class, 'articles'])->name('articles.index');
Route::get('/berita/{slug}', [PublicController::class, 'articleShow'])->name('articles.show');

// Halaman Menu Lainnya
Route::get('/fasilitas', [PublicController::class, 'facilities'])->name('facilities.index');
Route::get('/galeri', [PublicController::class, 'galleries'])->name('galleries.index');
Route::get('/program', [PublicController::class, 'programs'])->name('programs.index');
Route::get('/testimoni', [PublicController::class, 'testimonials'])->name('testimonials.index');

// Halaman PPDB (Dari pengerjaan sebelumnya)
Route::get('/ppdb/daftar', function () {
    $period = \App\Models\RegistrationPeriod::where('is_active', true)->firstOrFail();
    $settings = \App\Models\SiteSetting::first();
    return view('pages.ppdb.register', compact('period', 'settings'));
})->name('ppdb.register');

Route::get('/ppdb/success', function () {
    return view('pages.ppdb.success');
});