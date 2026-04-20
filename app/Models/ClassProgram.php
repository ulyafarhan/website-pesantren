<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClassProgram extends Model
{
    use HasUuids, HasFactory;

    protected $fillable = [
        'name',
        'description',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // ─── Scopes ────────────────────────────────────────────────────────────────

    /**
     * Hanya ambil kolom yang dibutuhkan untuk listing publik.
     * Penggunaan: ClassProgram::forList()->get();
     */
    public function scopeForList(Builder $query): void
    {
        $query->select(['id', 'name', 'description']);
    }
}