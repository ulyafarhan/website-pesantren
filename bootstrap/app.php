<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use App\Http\Middleware\SecurityHeaders;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;



return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        // Mendaftarkan SecurityHeaders secara global
        $middleware->append(SecurityHeaders::class);
        
        // FullPageCache diterapkan via route group di web.php (bukan global)
        // agar lebih terkontrol dan tidak double-apply
    })
    ->withExceptions(function (Exceptions $exceptions) {
        // Memastikan respons API selalu berupa JSON, bukan halaman HTML error
        $exceptions->render(function (Throwable $e, Request $request) {
            if ($request->is('api/*') || $request->wantsJson()) {
                
                // Khusus untuk 404 di API
                if ($e instanceof NotFoundHttpException) {
                    return response()->json([
                        'status' => 'error',
                        'message' => 'Endpoint API tidak ditemukan.'
                    ], 404);
                }

                // Untuk error server lainnya di API (hanya jika APP_DEBUG=false)
                if (! app()->hasDebugModeEnabled()) {
                    return response()->json([
                        'status' => 'error',
                        'message' => 'Terjadi kesalahan internal pada server.'
                    ], 500);
                }
            }
        });
    })->create();