<?php

declare(strict_types=1);

namespace App\Models;

use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements FilamentUser
{
    use HasUuids, Notifiable, HasFactory;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'created_at'        => 'datetime',
        'updated_at'        => 'datetime',
    ];

    // ─── Scopes ────────────────────────────────────────────────────────────────

    /**
     * Hanya user dengan role ADMIN.
     */
    public function scopeAdmins(Builder $query): void
    {
        $query->where('role', 'ADMIN');
    }

    /**
     * Hanya user dengan role EDITOR.
     */
    public function scopeEditors(Builder $query): void
    {
        $query->where('role', 'EDITOR');
    }

    // ─── Relationships ─────────────────────────────────────────────────────────

    public function articles(): HasMany
    {
        return $this->hasMany(Article::class, 'author_id');
    }

    // ─── Filament ──────────────────────────────────────────────────────────────

    /**
     * Hanya ADMIN dan EDITOR yang bisa masuk ke panel Filament.
     */
    public function canAccessPanel(Panel $panel): bool
    {
        return in_array($this->role, ['ADMIN', 'EDITOR'], true);
    }

    // ─── Helpers ───────────────────────────────────────────────────────────────

    public function isAdmin(): bool
    {
        return $this->role === 'ADMIN';
    }

    public function isEditor(): bool
    {
        return $this->role === 'EDITOR';
    }
}