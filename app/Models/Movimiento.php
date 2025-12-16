<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Movimiento extends Model
{
    use HasFactory;
    
    protected $table = 'movimientos';

    protected $fillable = [
        'cuenta_contable_id',
        'tipo', // 'Ingreso' o 'Gasto'
        'concepto',
        'fecha',
        'cantidad',
        'documento_referencia',
        'comprobante_path'
        // 'categoria_id', // Cuando se implemente
    ];

    protected $casts = [
        'fecha' => 'date',
        'cantidad' => 'decimal:2',
    ];

    /**
     * Relación: Un movimiento pertenece a una cuenta contable.
     */
    public function cuentaContable(): BelongsTo
    {
        return $this->belongsTo(CuentaContable::class, 'cuenta_contable_id');
    }
}