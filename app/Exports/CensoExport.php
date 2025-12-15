<?php

namespace App\Exports;

use App\Models\Hermano;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings; // Para añadir la cabecera
use Carbon\Carbon;

class CensoExport implements FromCollection, WithHeadings
{
    protected $filterType;

    public function __construct(string $filterType)
    {
        $this->filterType = $filterType;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        // Lógica de Filtrado basada en el tipo recibido
        $query = Hermano::query();

        switch ($this->filterType) {
            case 'completo':
                $query->whereNotNull('fecha_alta');
                break;
            case 'activos':
                // Hermanos que computan en el censo activo (sin fecha de baja)
                $query->whereNull('fecha_baja');
                break;

            case 'baja':
                // Hermanos que están de baja
                $query->whereNotNull('fecha_baja');
                break;

            case 'difuntos':
                // Hermanos marcados como fallecidos
                $query->where('fallecido', true);
                break;

            case 'menores_edad':
                // Filtro clave: Hermanos que tienen menos de 18 años
                $dateLimit = Carbon::now()->subYears(18);
                $query->where('fecha_alta', '>', $dateLimit); // Simplificado: Los más recientes
                // [NOTA: Idealmente, usarías un campo de fecha de nacimiento si existiera]
                
                // Si tienes un campo 'fecha_nacimiento', la consulta sería:
                // $query->where('fecha_nacimiento', '>', $dateLimit);
                
                // Por ahora, asumiremos que si son recientes (fecha_alta > 18 años atrás), son menores.
                break;

            // Por defecto, exportar activos si el filtro no es reconocido
            default:
                $query->whereNull('fecha_baja');
                break;
        }

        // Seleccionar y ordenar las columnas a exportar
        return $query->get()->map(function ($hermano) {
            return [
                'ID' => $hermano->id,
                'Numero Hermano' => $hermano->numero_hermano,
                'Nombre' => $hermano->nombre,
                'Apellidos' => $hermano->apellido,
                'DNI' => $hermano->dni,
                'Fecha Alta' => $hermano->fecha_alta->format('d/m/Y'),
                'Domicilio' => "{$hermano->domicilio_calle} {$hermano->domicilio_numero}",
                'Poblacion' => $hermano->domicilio_poblacion,
                'CP' => $hermano->domicilio_cp,
                'Fallecido' => $hermano->fallecido ? 'Sí' : 'No',
                'Fecha Baja' => $hermano->fecha_baja ? $hermano->fecha_baja->format('d/m/Y') : '',
            ];
        });
    }

    /**
     * Define las cabeceras de la hoja de cálculo.
     */
    public function headings(): array
    {
        return [
            'ID',
            'Nº Hermano',
            'Nombre',
            'Apellidos',
            'DNI',
            'Fecha Alta',
            'Domicilio',
            'Población',
            'C.P.',
            'Fallecido',
            'Fecha Baja',
        ];
    }
}