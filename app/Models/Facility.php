<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Facility extends Model
{
    use HasUuids, HasFactory;

    protected $fillable = [
        'name',
        'description',
        'image_url',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // ─── Scopes ────────────────────────────────────────────────────────────────

    /**
     * Kolom minimum untuk listing publik (tidak tarik 'description' panjang).
     * Penggunaan: Facility::forCard()->get();
     */
    public function scopeForCard(Builder $query): void
    {
        $query->select(['id', 'name', 'image_url', 'description']);
    }

    // ─── Accessors ─────────────────────────────────────────────────────────────

    /**
     * image_url mengembalikan URL lengkap atau null.
     * Fallback ditangani di Blade via onerror.
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