<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Registration extends Model
{
    use HasUuids;

    protected $fillable = [
        'registration_period_id',
        'registration_number',
        'full_name',
        'nik',
        'gender',
        'place_of_birth',
        'date_of_birth',
        'phone_number',
        'data',
        'documents',
        'status',
        'test_score',
        'admin_notes',
        'verified_at',
        'verified_by',
    ];

    protected $casts = [
        'data' => 'array',
        'documents' => 'array',
        'date_of_birth' => 'date',
        'verified_at' => 'datetime',
    ];

    public function period(): BelongsTo
    {
        return $this->belongsTo(RegistrationPeriod::class, 'registration_period_id');
    }

    public function verifiedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'verified_by');
    }
}