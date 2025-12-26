<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FastAccess extends Model
{
    protected $fillable = [
        'imagen_path',
        'alt_text',
        'url',
        'orden'
    ];
}
