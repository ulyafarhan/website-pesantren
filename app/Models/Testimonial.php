<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Testimonial extends Model
{
    use HasUuids;

    protected $fillable = [
        'name',
        'role',
        'message',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];
}