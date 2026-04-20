<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gallery extends Model
{
    use HasUuids, HasFactory;

    protected $fillable = [
        'title',
        'description',
        'image_url',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // ─── Scopes ────────────────────────────────────────────────────────────────

    /**
     * Kolom minimum untuk grid foto publik.
     * Penggunaan: Gallery::forGrid()->latest()->paginate(12);
     */
    public function scopeForGrid(Builder $query): void
    {
        $query->select(['id', 'title', 'image_url']);
    }

    // ─── Accessors ─────────────────────────────────────────────────────────────

    /**
     * image_url mengembalikan URL lengkap.
     * ->shouldCache() mencegah asset() dipanggil berulang pada grid besar.
     */
    protected function imageUrl(): Attribute
    {
        return Attribute::make(
            get: fn(?string $value) => $value
                ? asset('storage/' . $value)
                : null,
        )->shouldCache();
    }
}