<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WebSetting extends Model
{
    protected $fillable = [
        'nombre_hermandad', 'logo_path', 'tema_id', 'color_primario', 
        'color_secundario', 'modulos_config', 'meta_title', 
        'meta_description', 'instagram_url', 'facebook_url'
    ];

    protected $casts = [
        'modulos_config' => 'array'
    ];
}