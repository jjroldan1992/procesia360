<?php

namespace App\Http\Controllers;

use App\Models\CuotaTarifa;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class CuotaTarifaController extends Controller
{
    /**
     * Muestra el listado de tarifas históricas.
     */
    public function index()
    {
        $tarifas = CuotaTarifa::orderBy('anio', 'desc')->paginate(10);
        // [CORRECTO] Apunta a admin/config/tarifas/index.blade.php
        return view('admin.config.tarifas.index', compact('tarifas')); 
    }

    /**
     * Muestra el formulario de creación.
     */
    public function create()
    {
        // Sugerimos el año siguiente al último creado
        $ultimoAnio = CuotaTarifa::max('anio') ?? date('Y');
        $anioSugerido = $ultimoAnio + 1;
        
        // [CORRECCIÓN] Apunta a admin/config/tarifas/create.blade.php
        return view('admin.config.tarifas.create', compact('anioSugerido'));
    }

    /**
     * Almacena una nueva tarifa.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'anio'                   => 'required|integer|unique:cuota_tarifas,anio|min:1900|max:2100',
            'importe_ordinario'      => 'required|numeric|min:0.01',
            'importe_extraordinario' => 'nullable|numeric|min:0',
            'activa'                 => 'required|boolean',
        ]);

        CuotaTarifa::create($data);

        // [CORRECCIÓN] Redirige al nombre de la ruta: config.tarifas.index
        return redirect()->route('config.tarifas.index') 
                         ->with('success', 'Tarifa de cuota para el año ' . $data['anio'] . ' creada correctamente.');
    }

    /**
     * Muestra el formulario de edición.
     */
    public function edit(CuotaTarifa $tarifa)
    {
        // [CORRECCIÓN] Apunta a admin/config/tarifas/edit.blade.php
        return view('admin.config.tarifas.edit', compact('tarifa'));
    }

    /**
     * Actualiza una tarifa.
     */
    public function update(Request $request, CuotaTarifa $tarifa)
    {
        $data = $request->validate([
            'anio'                   => ['required', 'integer', Rule::unique('cuota_tarifas', 'anio')->ignore($tarifa->id), 'min:1900', 'max:2100'],
            'importe_ordinario'      => 'required|numeric|min:0.01',
            'importe_extraordinario' => 'nullable|numeric|min:0',
            'activa'                 => 'required|boolean',
        ]);

        $tarifa->update($data);

        // [CORRECCIÓN] Redirige al nombre de la ruta: config.tarifas.index
        return redirect()->route('config.tarifas.index')
                         ->with('success', 'Tarifa para el año ' . $data['anio'] . ' actualizada correctamente.');
    }

    /**
     * Elimina una tarifa.
     */
    public function destroy(CuotaTarifa $tarifa)
    {
        $tarifa->delete();

        // [CORRECCIÓN] Redirige al nombre de la ruta: config.tarifas.index
        return redirect()->route('config.tarifas.index')
                         ->with('success', 'Tarifa del año ' . $tarifa->anio . ' eliminada.');
    }
}