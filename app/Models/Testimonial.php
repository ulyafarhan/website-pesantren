<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Testimonial extends Model
{
    use HasUuids, HasFactory;

    protected $fillable = [
        'name',
        'role',
        'message',
        'is_active',
    ];

    protected $casts = [
        'is_active'  => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // ─── Scopes ────────────────────────────────────────────────────────────────

    /**
     * Hanya testimonial yang diaktifkan oleh admin.
     * Penggunaan: Testimonial::active()->latest()->get();
     */
    public function scopeActive(Builder $query): void
    {
        $query->where('is_active', true);
    }

    /**
     * Kolom minimum untuk tampilan publik.
     * Penggunaan: Testimonial::forPublic()->active()->latest()->take(6)->get();
     */
    public function scopeForPublic(Builder $query): void
    {
        $query->select(['id', 'name', 'role', 'message']);
    }
}