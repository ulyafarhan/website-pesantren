<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Brochure extends Model
{
    use HasUuids;

    protected $fillable = [
        'title',
        'version', 
        'file_url'
    ];
}