<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Cache;
use App\Models\SiteSetting;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Blade::directive('cdn', function ($expression) {
            return "<?php echo 'https://wsrv.nl/?url=' . urlencode(asset(str_replace(['\'', '\"'], '', $expression))) . '&output=webp&we'; ?>";
        });

        // Berbagi data settings ke SEMUA file blade secara otomatis
        View::composer('*', function ($view) {
            $settings = Cache::remember('site_settings_global', now()->addDay(), function () {
                return SiteSetting::first() ?? (object) [
                    'site_name' => 'Pesantren Darussaadah',
                    'site_description' => 'Membentuk Generasi Qurani',
                ];
            });
            $view->with('settings', $settings);
        });
    }
}
