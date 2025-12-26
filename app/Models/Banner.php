<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Banner extends Model
{
    protected $fillable = [
        'titulo', 'subtitulo', 'imagen_path', 'texto_boton', 'url_boton', 'orden', 'activo'
    ];
}
