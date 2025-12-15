<?php

namespace App\Http\Controllers;

use App\Models\CuentaContable;
use Illuminate\Http\Request;

class CuentaContableController extends Controller
{
    /**
     * Muestra la lista de cuentas. (Index)
     */
    public function index()
    {
        $cuentas = CuentaContable::orderBy('activa', 'desc')->orderBy('nombre', 'asc')->get();
        
        return view('admin.cuentas.index', compact('cuentas'));
    }

    /**
     * Muestra el formulario para crear una nueva cuenta. (Create)
     */
    public function create()
    {
        return view('admin.cuentas.create');
    }

    /**
     * Almacena una nueva cuenta en la base de datos. (Store)
     */
    public function store(Request $request)
    {
        // 1. Reglas de validación
        $rules = [
            'nombre' => 'required|string|max:100',
            'tipo' => 'required|in:Banco,Efectivo',
            'saldo_inicial' => 'required|numeric',
            'entidad' => 'nullable|string|max:100',
            'activa' => 'boolean',
        ];

        // Regla condicional para IBAN: solo es requerido si el tipo es 'Banco'
        if ($request->input('tipo') === 'Banco') {
            $rules['iban'] = 'required|string|max:34'; // Se puede añadir una validación de formato IBAN más estricta si es necesario
        } else {
            $rules['iban'] = 'nullable';
        }

        $validatedData = $request->validate($rules);
        $validatedData['activa'] = $request->has('activa');
        $validatedData['saldo_actual'] = $validatedData['saldo_inicial']; // El saldo actual empieza en el saldo inicial

        // 2. Creación de la cuenta
        CuentaContable::create($validatedData);

        return redirect()->route('cuentas.index')->with('success', 'Cuenta contable creada con éxito.');
    }

    // ... (Métodos show, edit, update, destroy - se rellenan después) ...
    
    public function show(CuentaContable $cuenta)
    {
        // No implementaremos una vista de detalle compleja por ahora. Redireccionamos a la edición.
        return redirect()->route('cuentas.edit', $cuenta);
    }
    
    public function edit(CuentaContable $cuenta)
    {
        return view('admin.cuentas.edit', compact('cuenta'));
    }

    public function update(Request $request, CuentaContable $cuenta)
    {
        // 1. Reglas de validación
        $rules = [
            'nombre' => 'required|string|max:100',
            'tipo' => 'required|in:Banco,Efectivo',
            'saldo_inicial' => 'required|numeric',
            'entidad' => 'nullable|string|max:100',
            'activa' => 'boolean',
            // El saldo actual no se permite editar aquí, solo se cambia con movimientos.
        ];

        if ($request->input('tipo') === 'Banco') {
            $rules['iban'] = 'required|string|max:34';
        } else {
            $rules['iban'] = 'nullable';
        }

        $validatedData = $request->validate($rules);
        $validatedData['activa'] = $request->has('activa');
        
        // 2. Actualización de la cuenta
        $cuenta->update($validatedData);

        return redirect()->route('cuentas.index')->with('success', 'Cuenta contable actualizada con éxito.');
    }

    public function destroy(CuentaContable $cuenta)
    {
        // NOTA: Se debería verificar si hay movimientos asociados antes de eliminar
        $cuenta->delete();
        return redirect()->route('cuentas.index')->with('success', 'Cuenta contable eliminada con éxito.');
    }
}