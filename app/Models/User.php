<?php

namespace App\Models;

use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements FilamentUser
{
    use HasUuids, Notifiable;

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

    /**
     * Relasi ke model Article.
     */
    public function articles(): HasMany
    {
        return $this->hasMany(Article::class, 'author_id');
    }

    /**
     * Menentukan apakah user boleh masuk ke panel Filament.
     */
    public function canAccessPanel(Panel $panel): bool
    {
        // Logika akses: Harus admin ATAU menggunakan email gmail (sesuai kebutuhan Anda)
        return $this->role === 'ADMIN' || str_ends_with($this->email, '@gmail.com');
    }
}