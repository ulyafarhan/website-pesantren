<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\PublicApiController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::prefix('v1')->group(function () {
    Route::get('/articles', [PublicApiController::class, 'articles']);
    Route::get('/articles/{slug}', [PublicApiController::class, 'articleShow']);
    Route::get('/galleries', [PublicApiController::class, 'galleries']);
    Route::get('/facilities', [PublicApiController::class, 'facilities']);
    Route::get('/class-programs', [PublicApiController::class, 'classPrograms']);
    Route::get('/brochures', [PublicApiController::class, 'brochures']);
    Route::get('/testimonials', [PublicApiController::class, 'testimonials']);
    Route::get('/settings', [PublicApiController::class, 'siteSettings']);
    Route::get('/registration-periods/active', [PublicApiController::class, 'activeRegistrationPeriod']);
    Route::post('/register', [PublicApiController::class, 'postRegister']);
});