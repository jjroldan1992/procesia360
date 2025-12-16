{{-- Este formulario se incluye en create.blade.php y edit.blade.php --}}
@csrf

<div class="form-group">
    <label for="anio">Año de la Tarifa *</label>
    <input type="number" name="anio" id="anio" class="form-input @error('anio') is-invalid @enderror" 
           value="{{ old('anio', $tarifa->anio ?? $anioSugerido ?? date('Y')) }}" 
           {{ isset($tarifa) ? 'readonly' : '' }} 
           required>
    @error('anio')<small class="text-danger">{{ $message }}</small>@enderror
    @if(isset($tarifa))
        <small class="text-muted">El año no se puede cambiar una vez creada la tarifa.</small>
    @endif
</div>

<div class="form-group">
    <label for="importe_ordinario">Importe Ordinario (€) *</label>
    <input type="number" step="0.01" name="importe_ordinario" id="importe_ordinario" class="form-input @error('importe_ordinario') is-invalid @enderror" 
           value="{{ old('importe_ordinario', $tarifa->importe_ordinario ?? '') }}" required>
    @error('importe_ordinario')<small class="text-danger">{{ $message }}</small>@enderror
</div>

<div class="form-group">
    <label for="importe_extraordinario">Importe Extraordinario (€) (Opcional)</label>
    <input type="number" step="0.01" name="importe_extraordinario" id="importe_extraordinario" class="form-input @error('importe_extraordinario') is-invalid @enderror" 
           value="{{ old('importe_extraordinario', $tarifa->importe_extraordinario ?? '') }}">
    @error('importe_extraordinario')<small class="text-danger">{{ $message }}</small>@enderror
</div>

<div class="form-group checkbox-group">
    <input type="hidden" name="activa" value="0">
    <input type="checkbox" name="activa" id="activa" value="1" 
           {{ old('activa', $tarifa->activa ?? true) ? 'checked' : '' }}>
    <label for="activa" class="checkbox-label">Activar esta tarifa para el año actual.</label>
    @error('activa')<small class="text-danger">{{ $message }}</small>@enderror
</div>