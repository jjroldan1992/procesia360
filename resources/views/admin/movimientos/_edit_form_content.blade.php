{{-- *********************************************** --}}
{{-- CONTENIDO DEL FORMULARIO DE EDICIÓN DE MOVIMIENTO --}}
{{-- Se espera la variable $cuentas --}}
{{-- *********************************************** --}}

<div class="offcanvas-title">
    <h3>Editar Movimiento</h3>
    {{-- Usamos la clase de cierre estándar --}}
    <button type="button" class="close-offcanvas-btn close-modal-btn">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-x"><path d="M18 6 6 18"></path><path d="m6 6 12 12"></path></svg>
    </button>
</div>

<form id="edit-movimiento-form" method="POST" action="">
    @csrf
    @method('PATCH')

    {{-- Campo oculto para el Tipo (Ingreso/Gasto). Es crucial para la lógica del observer, aunque no editable. --}}
    <input type="hidden" name="tipo" id="edit-movimiento-tipo" value="">
    
    {{-- Campo Cuenta Contable --}}
    <div class="form-group">
        <label for="edit-cuenta_contable_id">Cuenta Contable *</label>
        {{-- Usaremos el valor de old() en el futuro, pero aquí no aplica ya que se rellena con JS --}}
        <select name="cuenta_contable_id" id="edit-cuenta_contable_id" class="form-input @error('cuenta_contable_id') is-invalid @enderror" required>
            @foreach($cuentas as $cuenta)
                <option value="{{ $cuenta->id }}">{{ $cuenta->nombre }} ({{ $cuenta->tipo }})</option>
            @endforeach
        </select>
        @error('cuenta_contable_id')<small class="text-danger">{{ $message }}</small>@enderror
    </div>

    {{-- Campo Concepto --}}
    <div class="form-group">
        <label for="edit-concepto">Concepto *</label>
        <input type="text" name="concepto" id="edit-concepto" class="form-input @error('concepto') is-invalid @enderror" required>
        @error('concepto')<small class="text-danger">{{ $message }}</small>@enderror
    </div>

    {{-- Estructura de Dos Columnas (simulada con clase personalizada si no usas Tailwind) --}}
    {{-- NOTA: Si usas clases como grid grid-cols-2, debes agregarlas aquí. Por ahora, asumiremos que existe una clase de layout. --}}
    <div class="form-row-2-cols"> 
        {{-- Si no tienes la clase form-row-2-cols, usa: <div class="grid grid-cols-2 gap-4"> --}}
        
        {{-- Campo Cantidad --}}
        <div class="form-group">
            <label for="edit-cantidad">Cantidad (€) *</label>
            <input type="number" step="0.01" name="cantidad" id="edit-cantidad" class="form-input @error('cantidad') is-invalid @enderror" required min="0.01">
            @error('cantidad')<small class="text-danger">{{ $message }}</small>@enderror
        </div>

        {{-- Campo Fecha --}}
        <div class="form-group">
            <label for="edit-fecha">Fecha *</label>
            <input type="date" name="fecha" id="edit-fecha" class="form-input @error('fecha') is-invalid @enderror" required>
            @error('fecha')<small class="text-danger">{{ $message }}</small>@enderror
        </div>
    </div>
    
    {{-- Campo Documento Referencia (Opcional) --}}
    <div class="form-group">
        <label for="edit-documento_referencia">Documento de Referencia (Opcional)</label>
        <input type="text" name="documento_referencia" id="edit-documento_referencia" class="form-input @error('documento_referencia') is-invalid @enderror">
        <small class="text-muted">Ej: Nº de Factura, Nº de Recibo.</small>
        @error('documento_referencia')<small class="text-danger">{{ $message }}</small>@enderror
    </div>


    <div class="form-actions margin-top-large">
        <button type="button" class="btn btn-back close-modal-btn">Cancelar</button>
        <button type="submit" class="btn btn-primary">Guardar Cambios</button>
    </div>
</form>

{{-- NOTA: Si usas la clase 'form-row-2-cols' o 'margin-top-large', asegúrate de que estén definidas en tu app.css --}}
{{-- Si no existen, y usas Tailwind, usa: <div class="grid grid-cols-2 gap-4"> y <div class="form-actions mt-6"> --}}