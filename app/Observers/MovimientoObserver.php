<?php

namespace App\Observers;

use App\Models\Movimiento;
use App\Models\CuentaContable;
use Illuminate\Support\Facades\DB;

class MovimientoObserver
{
    /**
     * Lógica cuando se CREA un movimiento: Afecta el saldo.
     */
    public function created(Movimiento $movimiento): void
    {
        $this->updateCuentaSaldo($movimiento, 'created');
    }

    /**
     * Lógica cuando se ACTUALIZA un movimiento: Revierte lo viejo y aplica lo nuevo.
     */
    public function updated(Movimiento $movimiento): void
    {
        // 1. Revertir el impacto del movimiento original (en su cuenta original)
        $this->updateCuentaSaldo($movimiento, 'revert');

        // 2. Aplicar el impacto del nuevo movimiento (en su cuenta actual, que puede ser la misma o diferente)
        $this->updateCuentaSaldo($movimiento, 'created');
    }

    /**
     * Lógica cuando se ELIMINA un movimiento: Revierte el saldo.
     */
    public function deleted(Movimiento $movimiento): void
    {
        $this->updateCuentaSaldo($movimiento, 'revert');
    }

    /**
     * Función interna para manejar la lógica de actualización del saldo
     */
    protected function updateCuentaSaldo(Movimiento $movimiento, string $operation): void
    {
        // Determinamos qué datos y cuenta usar (originales si es 'revert', o actuales si es 'created')
        if ($operation === 'revert') {
            $cuentaId = $movimiento->getOriginal('cuenta_contable_id');
            $cantidad = $movimiento->getOriginal('cantidad');
            $tipo = $movimiento->getOriginal('tipo');
        } else { // 'created'
            $cuentaId = $movimiento->cuenta_contable_id;
            $cantidad = $movimiento->cantidad;
            $tipo = $movimiento->tipo;
        }

        // Recuperar la cuenta (asegurarse de que existe)
        $cuenta = CuentaContable::find($cuentaId);
        if (!$cuenta) {
            return; // No se encuentra la cuenta, salir.
        }
        
        // Determinar si sumar o restar:
        $isIngreso = ($tipo === 'Ingreso');
        
        // Si la operación es 'created' (aplicar):
        if ($operation === 'created') {
            // Ingreso suma, Gasto resta
            $change = $isIngreso ? $cantidad : -$cantidad;
        } 
        // Si la operación es 'revert' (revertir el impacto original):
        else { 
            // Ingreso original se revierte restando, Gasto original se revierte sumando
            $change = $isIngreso ? -$cantidad : $cantidad;
        }

        // Usar DB::transaction para garantizar la integridad
        DB::transaction(function () use ($cuenta, $change) {
            // Bloqueamos la fila para evitar condiciones de carrera en el saldo
            $cuenta->lockForUpdate();
            
            // Aplicar el cambio
            $cuenta->saldo_actual += $change;
            $cuenta->save();
        });
    }
}