<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SiteSetting extends Model
{
    protected $fillable = [
        'site_name',
        'site_description',
        'logo_url',
        'favicon_url',
        'email',
        'phone',
        'address',
        'google_maps_url',
        'facebook_url',
        'instagram_url',
        'youtube_url',
        'is_maintenance',
        'maintenance_message',
    ];

    protected $casts = [
        'is_maintenance' => 'boolean',
    ];
}