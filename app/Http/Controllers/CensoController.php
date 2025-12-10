<?php

namespace App\Http\Controllers;

use App\Models\Hermano; // Importamos el Modelo Hermano
use Illuminate\Http\Request;

class CensoController extends Controller
{
    /**
     * Muestra el listado del Censo de Hermanos. (READ: Index)
     */
    public function index()
    {
        // 1. Obtener todos los hermanos de la base de datos
        // Usamos paginate(25) para evitar cargar miles de registros a la vez
        $hermanos = Hermano::orderBy('fecha_alta', 'asc')->paginate(25);
        
        // 2. Devolver la vista, pasando la colección de hermanos
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
            // El DNI debe ser requerido, único en la tabla 'hermanos', y con formato básico
            'dni' => 'required|string|max:20|unique:hermanos,dni', 
            'fecha_alta' => 'required|date',
            // 'usuario_id' => 'nullable|exists:usuarios,id', // Se dejará nulo por ahora
        ]);

        // 2. Creación del registro
        Hermano::create($validatedData);

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
            
            // El DNI debe ser único, PERO IGNORAMOS el DNI del Hermano actual.
            // Esto permite editar otros campos sin que falle si el DNI no ha cambiado.
            'dni' => 'required|string|max:20|unique:hermanos,dni,' . $hermano->id, 
            
            'fecha_alta' => 'required|date',
        ]);

        // 2. Actualización del registro
        $hermano->update($validatedData);

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
        return redirect()->route('censo.index')->with('success', 'El Hermano ' . $hermano->nombre . ' ha sido eliminado del censo.');
    }
}