<?php

namespace App\Http\Controllers;

use App\Models\Hermano; // Importamos el Modelo Hermano
use Illuminate\Http\Request;
use App\Traits\RecalculaNumeroHermano;
use Maatwebsite\Excel\Facades\Excel; // Para generar el archivo
use App\Exports\CensoExport;          // La clase que acabamos de crear
use Carbon\Carbon;                    // Para el nombre del archivo

class CensoController extends Controller
{
    use RecalculaNumeroHermano;
    /**
     * Muestra el listado del Censo de Hermanos. (READ: Index)
     */
    public function index(Request $request)
    {
        // Obtener parámetros de ordenamiento
        $sortBy = $request->input('sort', 'fecha_alta'); // Ordenar por fecha_alta por defecto
        $direction = $request->input('direction', 'asc'); // Ascendente por defecto
        
        // Lista segura de columnas permitidas (para evitar inyección SQL)
        $allowedSorts = ['id', 'numero_hermano', 'nombre', 'dni', 'fecha_alta'];
        
        // Si la columna enviada no está permitida, usamos el valor por defecto
        if (!in_array($sortBy, $allowedSorts)) {
            $sortBy = 'fecha_alta';
        }
        // Si la dirección no es 'asc' o 'desc', usamos el valor por defecto
        if (!in_array($direction, ['asc', 'desc'])) {
            $direction = 'asc';
        }

        // 1. Construir la consulta con ordenamiento
        $query = Hermano::orderBy($sortBy, $direction); // <-- APLICAMOS EL ORDENAMIENTO
        
        // Lógica de Búsqueda (Se mantiene igual)
        if ($search = $request->input('search')) {
            $query->where(function($q) use ($search) {
                $q->where('nombre', 'like', "%{$search}%")
                  ->orWhere('apellido', 'like', "%{$search}%")
                  ->orWhere('dni', 'like', "%{$search}%");
            });
        }
    
        $hermanos = $query->paginate(10)->withQueryString();
    
        // ----------------------------------------------------
        // ¡CLAVE! Lógica para responder peticiones AJAX
        // ----------------------------------------------------
        if ($request->ajax()) {
            // Si es AJAX, solo devolvemos el contenido de la tabla y la paginación.
            // Usaremos una nueva vista parcial llamada 'admin.censo._results'
            return view('admin.censo._results', [
                'hermanos' => $hermanos
            ])->render();
        }
        
        // Si no es AJAX (recarga normal), devolvemos la vista completa.
        return view('admin.censo.index', [
            'hermanos' => $hermanos
        ]);
    }
    
    // ... Los otros métodos (create, store, show, edit, update, destroy) quedan por implementar.
    
    public function create()
    {
        // Devolver la vista con el formulario.
        return view('admin.censo.create');
    }

    public function store(Request $request)
    {
        // 1. Validación de los datos
        $validatedData = $request->validate([
            'nombre' => 'required|string|max:100',
            'apellido' => 'required|string|max:100',
            'dni' => 'nullable|string|max:20|unique:hermanos,dni', 
            'fecha_alta' => 'required|date',
            'fallecido' => 'boolean',
            'domicilio_calle'     => 'nullable|string|max:255',
            'domicilio_numero'    => 'nullable|string|max:255',
            'domicilio_cp'        => 'nullable|string|max:10',
            'domicilio_poblacion' => 'required|string|max:255', // Asumimos Población/Provincia son requeridos
            'domicilio_provincia' => 'required|string|max:255',
            // 'usuario_id' => 'nullable|exists:usuarios,id', // Se dejará nulo por ahora
        ]);
        $validatedData['fallecido'] = $request->has('fallecido');
        // 2. Creación del registro
        Hermano::create($validatedData);
        $this->recalcularNumeros();

        // 3. Redirección
        return redirect()->route('censo.index')->with('success', 'El Hermano ha sido añadido al censo con éxito.');
    }

    /**
     * Muestra la ficha detallada de un Hermano específico. (READ: Detalle)
     */
    public function show(Hermano $hermano)
    {
        // Laravel ya inyectó el objeto Hermano. 
        // Lo pasamos directamente a la vista.
        return view('admin.censo.show', [
            'hermano' => $hermano
        ]);
    }
    
    public function edit(Hermano $hermano)
    {
        // Laravel ya inyecta la instancia de Hermano basándose en el ID de la ruta.
        // Devolver la vista, pasando el objeto Hermano al formulario.
        return view('admin.censo.edit', [
            'hermano' => $hermano
        ]);
    }

    /**
     * Procesa la actualización de un Hermano en la base de datos. (UPDATE: Lógica)
     */
    public function update(Request $request, Hermano $hermano)
    {
        // 1. Validación de los datos
        $validatedData = $request->validate([
            'nombre' => 'required|string|max:100',
            'apellido' => 'required|string|max:100',
            'dni' => 'nullable|string|max:20|unique:hermanos,dni,' . $hermano->id, 
            'fecha_alta' => 'required|date',
            'fecha_baja' => 'nullable|date', // Puede ser nulo o una fecha
            'fallecido' => 'boolean',
            'domicilio_calle'     => 'nullable|string|max:255',
            'domicilio_numero'    => 'nullable|string|max:255',
            'domicilio_cp'        => 'nullable|string|max:10',
            'domicilio_poblacion' => 'required|string|max:255', // Asumimos Población/Provincia son requeridos
            'domicilio_provincia' => 'required|string|max:255',
        ]);
        $validatedData['fallecido'] = $request->has('fallecido');
        // 2. Actualización del registro
        $hermano->update($validatedData);
        $this->recalcularNumeros();

        // 3. Redirección
        return redirect()->route('censo.index')->with('success', 'El registro de ' . $hermano->nombre . ' ha sido actualizado con éxito.');
    }

    /**
     * Elimina un Hermano específico de la base de datos. (DELETE)
     */
    public function destroy(Hermano $hermano)
    {
        // 1. Eliminar el registro del Hermano
        $hermano->delete();

        // 2. Redirección
        $this->recalcularNumeros();
        return redirect()->route('censo.index')->with('success', 'El Hermano ' . $hermano->nombre . ' ha sido eliminado del censo.');
    }

    public function export(Request $request)
    {
        // Obtener el filtro seleccionado del modal. El valor por defecto es 'completo'.
        $filterType = $request->input('filter_type', 'completo'); 
        
        // Generar un nombre de archivo único con el filtro y la fecha/hora actual
        $filename = 'censo_' . $filterType . '_' . Carbon::now()->format('Ymd_His') . '.xlsx';

        // Devolver el archivo Excel
        return Excel::download(new CensoExport($filterType), $filename);
    }
}