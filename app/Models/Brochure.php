<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Brochure extends Model
{
    use HasUuids, HasFactory;

    protected $fillable = [
        'title',
        'version',
        'file_url',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // ─── Scopes ────────────────────────────────────────────────────────────────

    /**
     * Urutkan brosur terbaru di atas.
     * Penggunaan: Brochure::latest()->get();
     */
    public function scopeLatestFirst(Builder $query): void
    {
        $query->orderByDesc('created_at');
    }

    // ─── Accessors ─────────────────────────────────────────────────────────────

    /**
     * file_url mengembalikan URL lengkap file yang bisa diunduh.
     * ->shouldCache() agar tidak recompute pada collection.
     */
    protected function fileUrl(): Attribute
    {
        return Attribute::make(
            get: fn(?string $value) => $value
                ? asset('storage/' . $value)
                : null,
        )->shouldCache();
    }
}