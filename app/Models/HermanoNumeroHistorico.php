<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HermanoNumeroHistorico extends Model
{
    use HasFactory;
    
    // Nombre de la tabla
    protected $table = 'hermano_numeros_historico';

    protected $fillable = [
        'hermano_id',
        'numero_obtenido',
        'fecha_asignacion',
        'motivo',
    ];

    protected $casts = [
        'fecha_asignacion' => 'date',
    ];

    // Relación inversa al hermano
    public function hermano()
    {
        return $this->belongsTo(Hermano::class);
    }
}