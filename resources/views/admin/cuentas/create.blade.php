@extends('layouts.admin')

@section('title', 'Añadir Cuenta Contable')

@section('content')

<div class="section-one-col">

    <div class="content-card">
        <form action="{{ route('cuentas.store') }}" method="POST">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                {{-- Campo Nombre --}}
                <div class="form-group">
                    <label for="nombre">Nombre de la Cuenta *</label>
                    <input type="text" name="nombre" id="nombre" class="form-input @error('nombre') is-invalid @enderror" value="{{ old('nombre') }}" required>
                    @error('nombre')<small class="text-danger">{{ $message }}</small>@enderror
                    <small class="text-muted">Ej: Cuenta Principal BBVA, Caja 2024, etc.</small>
                </div>

                {{-- Campo Tipo (Banco / Efectivo) --}}
                <div class="form-group">
                    <label for="tipo">Tipo de Cuenta *</label>
                    <select name="tipo" id="tipo" class="form-input @error('tipo') is-invalid @enderror" required>
                        <option value="Banco" {{ old('tipo') === 'Banco' ? 'selected' : '' }}>Cuenta Bancaria</option>
                        <option value="Efectivo" {{ old('tipo') === 'Efectivo' ? 'selected' : '' }}>Caja / Efectivo</option>
                    </select>
                    @error('tipo')<small class="text-danger">{{ $message }}</small>@enderror
                </div>

                {{-- Campo IBAN (Condicional) --}}
                <div class="form-group" id="iban-group">
                    <label for="iban">IBAN *</label>
                    <input type="text" name="iban" id="iban" class="form-input @error('iban') is-invalid @enderror" value="{{ old('iban') }}" placeholder="Ej: ES91 0000 0000 0000 0000 0000">
                    @error('iban')<small class="text-danger">{{ $message }}</small>@enderror
                    <small class="text-muted">Necesario solo si el tipo es 'Cuenta Bancaria'.</small>
                </div>

                {{-- Campo Entidad (Condicional) --}}
                <div class="form-group" id="entidad-group">
                    <label for="entidad">Entidad Bancaria</label>
                    <input type="text" name="entidad" id="entidad" class="form-input @error('entidad') is-invalid @enderror" value="{{ old('entidad') }}" placeholder="Ej: Banco Bilbao Vizcaya Argentaria">
                    @error('entidad')<small class="text-danger">{{ $message }}</small>@enderror
                </div>
                
                {{-- Campo Saldo Inicial --}}
                <div class="form-group">
                    <label for="saldo_inicial">Saldo Inicial (€) *</label>
                    <input type="number" name="saldo_inicial" id="saldo_inicial" class="form-input @error('saldo_inicial') is-invalid @enderror" value="{{ old('saldo_inicial', 0.00) }}" step="0.01" required>
                    @error('saldo_inicial')<small class="text-danger">{{ $message }}</small>@enderror
                    <small class="text-muted">Saldo con el que se abre la cuenta (Ej: 1500.00).</small>
                </div>
                
                {{-- Campo Activa --}}
                <div class="form-group col-span-1 md:col-span-2">
                    <div class="flex items-center space-x-2">
                        <label for="activa" class="text-sm font-medium text-gray-700 dark:text-gray-300">
                        <input type="checkbox" name="activa" id="activa" class="form-checkbox" value="1" {{ old('activa', 1) ? 'checked' : '' }}>
                        Cuenta activa</label>
                    </div>
                    <small class="text-muted">Desmarcar si la cuenta ya no se utilizará para movimientos.</small>
                </div>

            </div>
            
            <hr class="my-6 border-gray-200 dark:border-gray-700">

            {{-- Botones de Acción --}}
            <div class="flex justify-end space-x-4">
                <a href="{{ route('cuentas.index') }}" class="btn btn-back">Cancelar</a>
                <button type="submit" class="btn btn-primary">Guardar Cuenta</button>
            </div>

        </form>

    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const tipoSelect = document.getElementById('tipo');
        const ibanGroup = document.getElementById('iban-group');
        const ibanInput = document.getElementById('iban');
        const entidadGroup = document.getElementById('entidad-group');

        // Función para mostrar/ocultar campos bancarios
        function toggleIbanFields() {
            const isBanco = tipoSelect.value === 'Banco';
            
            // Toggle visibilidad del IBAN
            ibanGroup.style.display = isBanco ? 'block' : 'none';
            entidadGroup.style.display = isBanco ? 'block' : 'none';

            // Marcar IBAN como requerido/no requerido para validación frontend
            if (isBanco) {
                ibanInput.setAttribute('required', 'required');
            } else {
                ibanInput.removeAttribute('required');
                // Opcional: limpiar el valor si se cambia a Efectivo
                ibanInput.value = ''; 
            }
        }

        // 1. Ejecutar al cargar la página
        toggleIbanFields(); 

        // 2. Ejecutar al cambiar el valor del select
        tipoSelect.addEventListener('change', toggleIbanFields);
    });
</script>

@endsection