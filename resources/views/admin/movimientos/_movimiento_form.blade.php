{{-- *********************************************** --}}
{{-- FORMULARIO PARA AÑADIR MOVIMIENTO (Ingreso/Gasto) --}}
{{-- El parámetro $tipo (Ingreso o Gasto) se pasa al incluir esta vista --}}
{{-- *********************************************** --}}

<div class="offcanvas-title">
    <h3>Nuevo {{ $tipo }}</h3>
    <button type="button" class="close-offcanvas-btn">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-x"><path d="M18 6 6 18"></path><path d="m6 6 12 12"></path></svg>
    </button>
</div>

<form method="POST" action="{{ route('movimientos.store') }}">
    @csrf

    {{-- Campo oculto para el Tipo de Movimiento (Ingreso/Gasto) --}}
    <input type="hidden" name="tipo" value="{{ $tipo }}">

    {{-- Mensajes de error específicos si Laravel redirecciona de vuelta con errores --}}
    @if ($errors->has('tipo') && old('tipo') === $tipo)
        <div class="alert alert-danger mb-3">
            Por favor, corrige los errores del formulario de {{ $tipo }}.
        </div>
    @endif
    
    {{-- Campo Cuenta Contable --}}
    <div class="form-group">
        <label for="cuenta_contable_id_{{ $tipo }}">Cuenta Contable *</label>
        <select name="cuenta_contable_id" id="cuenta_contable_id_{{ $tipo }}" class="form-input @error('cuenta_contable_id') is-invalid @enderror" required>
            <option value="">-- Selecciona Cuenta --</option>
            @foreach (App\Models\CuentaContable::where('activa', true)->get() as $cuenta)
                <option value="{{ $cuenta->id }}" {{ old('cuenta_contable_id') == $cuenta->id ? 'selected' : '' }}>
                    {{ $cuenta->nombre }} ({{ $cuenta->tipo }})
                </option>
            @endforeach
        </select>
        @error('cuenta_contable_id')<small class="text-danger">{{ $message }}</small>@enderror
    </div>

    {{-- Campo Concepto --}}
    <div class="form-group">
        <label for="concepto_{{ $tipo }}">Concepto *</label>
        <input type="text" name="concepto" id="concepto_{{ $tipo }}" class="form-input @error('concepto') is-invalid @enderror" value="{{ old('concepto') }}" required>
        @error('concepto')<small class="text-danger">{{ $message }}</small>@enderror
    </div>

    <div class="grid grid-cols-2 gap-4">
        {{-- Campo Cantidad --}}
        <div class="form-group">
            <label for="cantidad_{{ $tipo }}">Cantidad (€) *</label>
            <input type="number" name="cantidad" id="cantidad_{{ $tipo }}" class="form-input @error('cantidad') is-invalid @enderror" value="{{ old('cantidad') }}" step="0.01" min="0.01" required>
            @error('cantidad')<small class="text-danger">{{ $message }}</small>@enderror
        </div>

        {{-- Campo Fecha --}}
        <div class="form-group">
            <label for="fecha_{{ $tipo }}">Fecha *</label>
            <input type="date" name="fecha" id="fecha_{{ $tipo }}" class="form-input @error('fecha') is-invalid @enderror" value="{{ old('fecha', date('Y-m-d')) }}" required>
            @error('fecha')<small class="text-danger">{{ $message }}</small>@enderror
        </div>
    </div>
    
    {{-- Campo Documento Referencia (Opcional) --}}
    <div class="form-group">
        <label for="documento_referencia_{{ $tipo }}">Documento de Referencia (Opcional)</label>
        <input type="text" name="documento_referencia" id="documento_referencia_{{ $tipo }}" class="form-input @error('documento_referencia') is-invalid @enderror" value="{{ old('documento_referencia') }}">
        <small class="text-muted">Ej: Nº de Factura, Nº de Recibo.</small>
        @error('documento_referencia')<small class="text-danger">{{ $message }}</small>@enderror
    </div>


    <div class="form-actions mt-6">
        <button type="button" class="btn btn-back cancel-movimiento-btn">Cancelar</button>
        <button type="submit" class="btn btn-primary">
            Guardar {{ $tipo }}
        </button>
    </div>
</form>