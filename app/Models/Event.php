<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $fillable = ['titulo', 'fecha', 'hora', 'tipo', 'lugar', 'observaciones', 'cartel_path', 'activo'];
}
