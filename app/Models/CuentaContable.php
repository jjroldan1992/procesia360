<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CuentaContable extends Model
{
    use HasFactory;
    
    // Nombre de la tabla
    protected $table = 'cuentas_contables';

    protected $fillable = [
        'nombre',
        'tipo',
        'iban',
        'entidad',
        'saldo_inicial',
        'saldo_actual',
        'activa',
    ];

    protected $casts = [
        'saldo_inicial' => 'decimal:2',
        'saldo_actual' => 'decimal:2',
        'activa' => 'boolean',
    ];

    /**
     * Relación: Una cuenta contable tiene muchos movimientos.
     */
    public function movimientos(): HasMany
    {
        return $this->hasMany(Movimiento::class, 'cuenta_contable_id');
    }
}