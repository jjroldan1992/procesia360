<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CuotaTarifa extends Model
{
    use HasFactory;

    protected $fillable = [
        'anio',
        'importe_ordinario',
        'importe_extraordinario',
        'activa',
    ];

    // Aseguramos que 'anio' sea tratado como entero
    protected $casts = [
        'anio' => 'integer',
        'activa' => 'boolean',
    ];
}