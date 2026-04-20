<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class SiteSetting extends Model
{
    protected $fillable = [
        'site_name',
        'site_description',
        'logo_url',
        'favicon_url',
        'email',
        'phone',
        'address',
        'google_maps_url',
        'facebook_url',
        'instagram_url',
        'youtube_url',
        'is_maintenance',
        'maintenance_message',
    ];

    protected $casts = [
        'is_maintenance' => 'boolean',
        'created_at'     => 'datetime',
        'updated_at'     => 'datetime',
    ];

    // ─── Static Helpers ────────────────────────────────────────────────────────

    /**
     * Ambil settings dari cache, fallback ke query DB jika cache miss.
     * Ini menggantikan pola Cache::remember() yang berulang di setiap controller.
     *
     * Penggunaan: $settings = SiteSetting::getInstance();
     */
    public static function getInstance(): static
    {
        return Cache::remember('site_settings_global', now()->addDay(), function () {
            return static::first() ?? new static([
                'site_name'        => 'Pesantren Darussaadah',
                'site_description' => 'Membentuk Generasi Qurani',
            ]);
        });
    }

    /**
     * Paksa invalidasi cache settings — dipanggil dari Observer saat admin update.
     */
    public static function flushCache(): void
    {
        Cache::forget('site_settings_global');
        Cache::forget('api_site_settings');
    }

    // ─── Accessors ─────────────────────────────────────────────────────────────

    /**
     * logo_url mengembalikan URL lengkap atau null.
     */
    protected function logoUrl(): Attribute
    {
        return Attribute::make(
            get: fn(?string $value) => $value
                ? asset('storage/' . $value)
                : null,
        )->shouldCache();
    }

    /**
     * favicon_url mengembalikan URL lengkap atau null.
     */
    protected function faviconUrl(): Attribute
    {
        return Attribute::make(
            get: fn(?string $value) => $value
                ? asset('storage/' . $value)
                : null,
        )->shouldCache();
    }

    // ─── Helpers ───────────────────────────────────────────────────────────────

    /**
     * Mengembalikan array URL media sosial yang terisi saja (skip yang null).
     * Berguna untuk JSON-LD sameAs dan footer links.
     */
    public function socialLinks(): array
    {
        return array_filter([
            'facebook'  => $this->facebook_url,
            'instagram' => $this->instagram_url,
            'youtube'   => $this->youtube_url,
        ]);
    }
}