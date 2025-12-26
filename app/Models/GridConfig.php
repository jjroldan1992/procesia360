<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GridConfig extends Model
{
    protected $fillable = ['tipos_permitidos', 'cantidad_mostrar', 'titulo_seccion'];

    protected $casts = [
        'tipos_permitidos' => 'array'
    ];
}
