<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * Tentukan namespace rute untuk aplikasi Anda.
     * * Proyek dasar Laravel biasanya tidak perlu menentukan namespace di sini.
     * Namespace biasanya akan mengarah ke namespace controller Anda saat ini.
     *
     * @var string|null
     */
    protected $namespace = 'App\\Http\\Controllers';

    /**
     * Metode boot.
     *
     * @return void
     */
    public function boot()
    {
        $this->configureRateLimiting();

        $this->routes(function () {
            
            // =========================================================
            // BAGIAN KRUSIAL: Memuat routes/api.php
            // Memastikan semua rute di file ini memiliki prefix /api 
            // dan menggunakan middleware 'api' (Rate Limiter, dll.).
            // =========================================================
            Route::middleware('api')
                ->prefix('api')
                ->namespace($this->namespace)
                ->group(base_path('routes/api.php'));

            // Memuat routes/web.php
            Route::middleware('web')
                ->namespace($this->namespace)
                ->group(base_path('routes/web.php'));
        });
    }

    /**
     * Konfigurasikan pembatas laju untuk aplikasi.
     *
     * @return void
     */
    protected function configureRateLimiting()
    {
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by(optional($request->user())->id ?: $request->ip());
        });
    }
}