<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TablonParroquial extends Model
{
    // Laravel buscará 'tablon_parroquial' por defecto. 
    // Si prefieres ser explícito, déjalo así:
    protected $table = 'tablon_parroquial';

    protected $fillable = [
        'titulo', 
        'contenido', 
        'tipo', 
        'fecha_exposicion', 
        'fecha_finalizacion', 
        'adjunto_path', 
        'fijado'
    ];

    protected $casts = [
        'fecha_exposicion' => 'date',
        'fecha_finalizacion' => 'date',
        'fijado' => 'boolean'
    ];
}