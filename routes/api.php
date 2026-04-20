<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\PublicApiController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

/**
 * API Publik v1 — Rate Limited
 * GET endpoints: 60 request/menit
 * POST register: 5 request/menit (anti-abuse)
 */
Route::prefix('v1')->middleware('throttle:60,1')->group(function () {
    Route::get('/articles', [PublicApiController::class, 'articles']);
    Route::get('/articles/{slug}', [PublicApiController::class, 'articleShow']);
    Route::get('/galleries', [PublicApiController::class, 'galleries']);
    Route::get('/facilities', [PublicApiController::class, 'facilities']);
    Route::get('/class-programs', [PublicApiController::class, 'classPrograms']);
    Route::get('/brochures', [PublicApiController::class, 'brochures']);
    Route::get('/testimonials', [PublicApiController::class, 'testimonials']);
    Route::get('/settings', [PublicApiController::class, 'siteSettings']);
    Route::get('/registration-periods/active', [PublicApiController::class, 'activeRegistrationPeriod']);

    // Throttle ketat untuk endpoint pendaftaran (mencegah spam registrasi)
    Route::post('/register', [PublicApiController::class, 'postRegister'])->middleware('throttle:5,1');
});