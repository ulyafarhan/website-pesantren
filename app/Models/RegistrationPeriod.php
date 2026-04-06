<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class RegistrationPeriod extends Model
{
    use HasUuids;

    protected $fillable = [
        'name',
        'is_active',
        'form_schema',
        'document_schema',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'form_schema' => 'array',
        'document_schema' => 'array',
    ];

    public function registrations(): HasMany
    {
        return $this->hasMany(Registration::class);
    }
}