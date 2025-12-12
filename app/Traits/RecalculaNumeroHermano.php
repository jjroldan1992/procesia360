<?php

namespace App\Traits;

use App\Models\Hermano;
use App\Models\HermanoNumeroHistorico;
use Carbon\Carbon;

trait RecalculaNumeroHermano
{
    /**
     * Recalcula el numero_hermano para TODOS los hermanos activos
     * basándose en su fecha_alta (el más antiguo es el número 1).
     * Y registra el cambio si el número es nuevo.
     */
    protected function recalcularNumeros()
    {
        // 1. OBTENER SOLO HERMANOS ACTIVOS
        // Filtramos CLAVE: solo se incluyen en el censo activo los hermanos donde fecha_baja es NULL.
        // Ordenamos por fecha_alta (ascendente = más antiguos primero)
        $hermanosActivos = Hermano::whereNull('fecha_baja')
                                ->orderBy('fecha_alta', 'asc')
                                ->get();

        $numeroActual = 1;
        $fechaRecalculo = Carbon::today();

        // 2. Asignar números a los activos
        foreach ($hermanosActivos as $hermano) {
            $numeroAnterior = $hermano->numero_hermano;
            
            if ($numeroAnterior !== $numeroActual) {
                // Actualizar el número actual
                $hermano->numero_hermano = $numeroActual;
                $hermano->save();

                // Registrar en el histórico
                HermanoNumeroHistorico::create([
                    'hermano_id' => $hermano->id,
                    'numero_obtenido' => $numeroActual,
                    'fecha_asignacion' => $fechaRecalculo,
                    'motivo' => $numeroAnterior === null ? 'Alta Inicial' : 'Recálculo por baja/fallecimiento en el censo',
                ]);
            }
            
            $numeroActual++;
        }
        
        // 3. Establecer el numero_hermano a NULL para los hermanos INACTIVOS
        // Esto es crucial para que no sigan mostrando un número obsoleto
        Hermano::whereNotNull('fecha_baja')
                ->whereNotNull('numero_hermano')
                ->update(['numero_hermano' => null]);
    }
}