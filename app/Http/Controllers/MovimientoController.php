<?php

namespace App\Http\Controllers;

use App\Models\Movimiento;
use App\Models\CuentaContable;
use Illuminate\Http\Request;
use Carbon\Carbon;

class MovimientoController extends Controller
{
    /**
     * Muestra el Dashboard principal de contabilidad (vista general).
     */
    public function dashboard()
    {
        $cuentas = CuentaContable::where('activa', true)->get();
        
        // 1. Resumen de saldos totales
        $saldoTotal = $cuentas->sum('saldo_actual');

        // 2. Movimientos del último mes (para el gráfico de resumen)
        $unMesAtras = Carbon::now()->subMonth();
        $movimientosRecientes = Movimiento::where('fecha', '>=', $unMesAtras)
            ->orderBy('fecha', 'desc')
            ->get();
            
        // 3. Resumen rápido
        $ingresosMes = $movimientosRecientes->where('tipo', 'Ingreso')->sum('cantidad');
        $gastosMes = $movimientosRecientes->where('tipo', 'Gasto')->sum('cantidad');


        return view('admin.tesoreria.dashboard', compact(
            'cuentas', 
            'saldoTotal',
            'ingresosMes',
            'gastosMes',
            'movimientosRecientes'
        ));
    }

    /**
     * Almacena un nuevo movimiento (Ingreso o Gasto) en la base de datos.
     */
    public function store(Request $request)
    {
        // 1. Validación de datos
        $validatedData = $request->validate([
            'cuenta_contable_id' => 'required|exists:cuentas_contables,id',
            'tipo'               => 'required|in:Ingreso,Gasto', // Validado en el campo oculto del modal
            'concepto'           => 'required|string|max:255',
            'fecha'              => 'required|date',
            'cantidad'           => 'required|numeric|min:0.01',
            'documento_referencia' => 'nullable|string|max:50',
        ]);
        
        // 2. Creación del Movimiento
        Movimiento::create($validatedData);

        // 3. Redirección
        $tipoMovimiento = $validatedData['tipo'];
        return redirect()->route('tesoreria.dashboard')->with('success', $tipoMovimiento . ' registrado correctamente. El saldo de la cuenta ha sido actualizado.');
    }

    /**
     * Muestra el listado completo y detallado de Movimientos Contables. (Index)
     */
    public function index(Request $request)
    {
        // 1. Obtener parámetros de ordenamiento
        $sortBy = $request->input('sort', 'fecha'); 
        $direction = $request->input('direction', 'desc'); // Por defecto: fecha descendente
        
        // Lista segura de columnas permitidas
        $allowedSorts = ['fecha', 'cantidad', 'tipo', 'concepto', 'cuenta_contable_id'];
        
        if (!in_array($sortBy, $allowedSorts)) {
            $sortBy = 'fecha';
        }
        if (!in_array($direction, ['asc', 'desc'])) {
            $direction = 'desc';
        }

        // 2. Construir la consulta con relaciones (CuentaContable) y ordenamiento
        $query = Movimiento::with('cuentaContable')
                    ->orderBy($sortBy, $direction);
        
        // Lógica de Búsqueda (simple, busca en concepto y referencia)
        if ($search = $request->input('search')) {
            $query->where(function($q) use ($search) {
                $q->where('concepto', 'like', "%{$search}%")
                ->orWhere('documento_referencia', 'like', "%{$search}%");
            });
        }

        // NUEVA LÓGICA DE FILTRO POR RANGO DE FECHAS
        $fechaInicio = $request->input('fecha_inicio');
        $fechaFin = $request->input('fecha_fin');

        if ($fechaInicio) {
            // Filtra desde la fecha de inicio (incluye ese día)
            $query->whereDate('fecha', '>=', $fechaInicio);
        }
        
        if ($fechaFin) {
            // Filtra hasta la fecha de fin (incluye ese día)
            $query->whereDate('fecha', '<=', $fechaFin);
        }

        // 3. Paginar resultados
        $movimientos = $query->paginate(10)->withQueryString();

        // 4. Obtener listado de cuentas para filtros (futuro) o solo para el header
        $cuentas = CuentaContable::orderBy('nombre')->get();
        
        return view('admin.movimientos.index', compact('movimientos', 'cuentas'));
    }

    /**
     * Muestra el formulario para editar un movimiento específico (vía modal/API).
     * En este caso, usaremos este método para obtener el JSON del movimiento.
     */
    public function edit(Movimiento $movimiento)
    {
        // Esto es útil si el frontend necesita AJAX para llenar un modal.
        // Dado que solo lo usamos internamente, devolvemos el objeto directamente.
        // También podemos precargar las cuentas para el select.
        $cuentas = CuentaContable::orderBy('nombre')->get(['id', 'nombre']);
        
        return response()->json([
            'movimiento' => $movimiento,
            'cuentas' => $cuentas->toArray() // Puede ser útil para rellenar el select
        ]);
    }


    /**
     * Actualiza el movimiento especificado en la base de datos.
     * El MovimientoObserver@updating se encarga de revertir el saldo antiguo y aplicar el nuevo.
     */
    public function update(Request $request, Movimiento $movimiento)
    {
        // 1. Validación de datos (Aseguramos que el tipo no cambie para mantener la lógica de saldos simple)
        $validatedData = $request->validate([
            // NOTA: No permitimos cambiar el 'tipo' (Ingreso/Gasto) en la edición para simplificar el Observer.
            'cuenta_contable_id' => 'required|exists:cuentas_contables,id',
            'concepto'           => 'required|string|max:255',
            'fecha'              => 'required|date',
            'cantidad'           => 'required|numeric|min:0.01',
            'documento_referencia' => 'nullable|string|max:50',
        ]);
        
        // 2. Actualización del Movimiento
        $movimiento->update($validatedData);

        // 3. Redirección
        return redirect()->route('movimientos.index')->with('success', 'Movimiento actualizado correctamente. El saldo de la cuenta ha sido recalculado.');
    }

    /**
     * Elimina el movimiento de la base de datos.
     * El MovimientoObserver@deleting se encarga de revertir el saldo.
     */
    public function destroy(Movimiento $movimiento)
    {
        $tipo = $movimiento->tipo;
        $movimiento->delete();

        return redirect()->route('movimientos.index')->with('success', $tipo . ' eliminado correctamente. El saldo de la cuenta ha sido revertido.');
    }
}