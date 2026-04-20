<?php

declare(strict_types=1);

namespace App\Providers;

use App\Models\Article;
use App\Models\Brochure;
use App\Models\ClassProgram;
use App\Models\Facility;
use App\Models\Gallery;
use App\Models\RegistrationPeriod;
use App\Models\SiteSetting;
use App\Models\Testimonial;
use App\Observers\ArticleObserver;
use App\Observers\BrochureObserver;
use App\Observers\ClassProgramObserver;
use App\Observers\FacilityObserver;
use App\Observers\GalleryObserver;
use App\Observers\RegistrationPeriodObserver;
use App\Observers\SiteSettingObserver;
use App\Observers\TestimonialObserver;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

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
        // ─── Infrastructure Optimization ──────────────────────────────────────
        // Paksa skema HTTPS di Production agar aset dan routing tidak mixed-content
        // Ini sangat penting jika berada di balik proxy/Cloudflare pada Shared Hosting
        if (app()->environment('production')) {
            URL::forceScheme('https');
        }

        // ─── Model Protection (Strict Mode) ───────────────────────────────────
        // Di development: Laravel akan CRASH dan menampilkan Exception jika ada N+1.
        // Ini praktik terbaik agar N+1 langsung ketahuan dan diperbaiki, bukan sekadar di-log.
        // Di production: Pencegahan dinonaktifkan agar aplikasi tetap jalan untuk user.
        Model::preventLazyLoading(! app()->isProduction());
        Model::preventSilentlyDiscardingAttributes(! app()->isProduction());
        Model::preventAccessingMissingAttributes(! app()->isProduction());

        // ─── Blade Directives ─────────────────────────────────────────────────
        // BUG FIX: Penggunaan {expression} sebelumnya di dalam string PHP compile
        // akan menghasilkan syntax error. Menggunakan konkatensi string yang benar.
        Blade::directive('cdn', function (string $expression): string {
            return "<?php echo 'https://wsrv.nl/?url=' . urlencode(asset(str_replace(['\'', '\"'], '', " . $expression . "))) . '&output=webp&we'; ?>";
        });

        // ─── View Composer ────────────────────────────────────────────────────
        // Membatasi query $settings hanya pada file/komponen publik.
        // Ini memastikan Panel Admin (Filament) tetap ringan dan tidak terbebani.
        View::composer(
            ['pages.*', 'components.navigations.*', 'components.sections.*', 'components.layouts.*'],
            function (\Illuminate\View\View $view): void {
                $settings = Cache::remember('site_settings_global', 86400, function () {
                    return SiteSetting::first() ?? new SiteSetting([
                        'site_name'        => 'Pesantren Darussaadah',
                        'site_description' => 'Membentuk Generasi Qurani',
                    ]);
                });
                $view->with('settings', $settings);
            }
        );

        // ─── Model Observers ──────────────────────────────────────────────────
        // Eksekusi otomatis untuk menghapus cache publik ketika admin
        // mengubah data melalui Filament Admin Panel.
        Article::observe(ArticleObserver::class);
        Brochure::observe(BrochureObserver::class);
        ClassProgram::observe(ClassProgramObserver::class);
        Facility::observe(FacilityObserver::class);
        Gallery::observe(GalleryObserver::class);
        RegistrationPeriod::observe(RegistrationPeriodObserver::class);
        SiteSetting::observe(SiteSettingObserver::class);
        Testimonial::observe(TestimonialObserver::class);
    }
}