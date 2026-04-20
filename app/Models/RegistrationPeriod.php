<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class RegistrationPeriod extends Model
{
    use HasUuids, HasFactory;

    protected $fillable = [
        'name',
        'start_date',
        'end_date',
        'quota',
        'registration_fee',
        'is_active',
        'form_schema',
        'document_schema',
    ];

    protected $casts = [
        'start_date'       => 'date',
        'end_date'         => 'date',
        'is_active'        => 'boolean',
        'form_schema'      => 'array',
        'document_schema'  => 'array',
        'quota'            => 'integer',
        'registration_fee' => 'float',
        'created_at'       => 'datetime',
        'updated_at'       => 'datetime',
    ];

    // ─── Scopes ────────────────────────────────────────────────────────────────

    /**
     * Hanya gelombang yang sedang dibuka.
     * Penggunaan: RegistrationPeriod::active()->first();
     */
    public function scopeActive(Builder $query): void
    {
        $query->where('is_active', true);
    }

    /**
     * Kolom minimum untuk endpoint publik (tidak tarik schema besar).
     * Penggunaan: RegistrationPeriod::forPublic()->active()->first();
     */
    public function scopeForPublic(Builder $query): void
    {
        $query->select([
            'id', 'name', 'start_date', 'end_date',
            'is_active', 'form_schema', 'document_schema',
        ]);
    }

    // ─── Relationships ─────────────────────────────────────────────────────────

    public function registrations(): HasMany
    {
        return $this->hasMany(Registration::class);
    }

    // ─── Helpers ───────────────────────────────────────────────────────────────

    /**
     * Jumlah pendaftar di gelombang ini — gunakan withCount() untuk efisiensi.
     * Penggunaan di query: RegistrationPeriod::withCount('registrations')->get();
     * Penggunaan setelah withCount: $period->registrations_count
     */
    public function getRemainingQuota(): int
    {
        if ($this->quota <= 0) {
            return PHP_INT_MAX; // Kuota tidak dibatasi
        }

        return max(0, $this->quota - $this->registrations()->count());
    }

    /**
     * Cek apakah kuota masih tersedia.
     */
    public function hasRemainingQuota(): bool
    {
        if ($this->quota <= 0) {
            return true;
        }

        return $this->registrations()->count() < $this->quota;
    }
}