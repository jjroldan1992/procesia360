<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WebSetting extends Model
{
    protected $fillable = [
        'nombre_hermandad', 
        'template', // Añadimos el nuevo
        'escudo_path', 
        'email_contacto', 
        'modulos_config'
        // 'tema_id' <-- Eliminado
    ];

    protected $casts = [
        'modulos_config' => 'array'
    ];
}