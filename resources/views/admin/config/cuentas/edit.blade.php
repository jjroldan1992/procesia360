@extends('layouts.admin')

@section('title', 'Editar Cuenta Contable')

@section('content')

<div class="section-one-col">

    <div class="content-card">
        <form action="{{ route('config.cuentas.update', $cuenta) }}" method="POST">
            @csrf
            @method('PUT') {{-- Usamos el método PUT para actualizaciones --}}

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                {{-- Campo Nombre --}}
                <div class="form-group">
                    <label for="nombre">Nombre de la Cuenta *</label>
                    <input type="text" name="nombre" id="nombre" class="form-input @error('nombre') is-invalid @enderror" 
                        value="{{ old('nombre', $cuenta->nombre) }}" required>
                    @error('nombre')<small class="text-danger">{{ $message }}</small>@enderror
                </div>

                {{-- Campo Tipo (No editable en el update para simplificar la lógica) --}}
                <div class="form-group">
                    <label for="tipo">Tipo de Cuenta</label>
                    <input type="text" value="{{ $cuenta->tipo === 'Banco' ? 'Cuenta Bancaria' : 'Caja / Efectivo' }}" class="form-input bg-gray-100 dark:bg-gray-700 cursor-not-allowed" disabled>
                    <input type="hidden" name="tipo" id="tipo" value="{{ $cuenta->tipo }}">
                    <small class="text-muted">El tipo de cuenta no se puede modificar.</small>
                </div>

                {{-- Campo IBAN (Condicional) --}}
                <div class="form-group" id="iban-group">
                    <label for="iban">IBAN @if($cuenta->tipo === 'Banco') * @endif</label>
                    <input type="text" name="iban" id="iban" class="form-input @error('iban') is-invalid @enderror" 
                        value="{{ old('iban', $cuenta->iban) }}" 
                        placeholder="Ej: ES91 0000 0000 0000 0000 0000">
                    @error('iban')<small class="text-danger">{{ $message }}</small>@enderror
                </div>

                {{-- Campo Entidad (Condicional) --}}
                <div class="form-group" id="entidad-group">
                    <label for="entidad">Entidad Bancaria</label>
                    <input type="text" name="entidad" id="entidad" class="form-input @error('entidad') is-invalid @enderror" 
                        value="{{ old('entidad', $cuenta->entidad) }}" 
                        placeholder="Ej: Banco Bilbao Vizcaya Argentaria">
                    @error('entidad')<small class="text-danger">{{ $message }}</small>@enderror
                </div>
                
                {{-- Campo Saldo Inicial (Deshabilitado, solo informativo) --}}
                <div class="form-group">
                    <label for="saldo_inicial">Saldo Inicial (€)</label>
                    <input type="text" value="{{ number_format($cuenta->saldo_inicial, 2, ',', '.') }}" class="form-input bg-gray-100 dark:bg-gray-700 cursor-not-allowed" disabled>
                    <small class="text-muted">El saldo inicial no es editable.</small>
                </div>
                
                {{-- Campo Saldo Actual (Informativo) --}}
                <div class="form-group">
                    <label for="saldo_actual">Saldo Actual (€)</label>
                    <input type="text" value="{{ number_format($cuenta->saldo_actual, 2, ',', '.') }}" class="form-input bg-gray-100 dark:bg-gray-700 font-bold cursor-not-allowed" disabled>
                    <small class="text-muted">El saldo actual se actualiza automáticamente con los movimientos.</small>
                </div>
                
                {{-- Campo Activa --}}
                <div class="form-group col-span-1 md:col-span-2">
                    <div class="flex items-center space-x-2">
                        {{-- El valor de 'activa' debe venir del modelo o de old(), por defecto 1 si no está en old() --}}
                        <label for="activa" class="text-sm font-medium text-gray-700 dark:text-gray-300">
                        <input type="checkbox" name="activa" id="activa" class="form-checkbox" value="1" 
                            {{ old('activa', $cuenta->activa) ? 'checked' : '' }}>
                        Cuenta activa</label>
                    </div>
                    @error('activa')<small class="text-danger">{{ $message }}</small>@enderror
                    <small class="text-muted">Desmarcar si la cuenta ya no se utilizará para movimientos.</small>
                </div>

            </div>
            
            <hr class="my-6 border-gray-200 dark:border-gray-700">

            {{-- Botones de Acción --}}
            <div class="flex justify-end space-x-4">
                <a href="{{ route('config.cuentas.index') }}" class="btn btn-back">Cancelar</a>
                <button type="submit" class="btn btn-primary">Guardar Cambios</button>
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
            // El tipo viene del campo oculto #tipo
            const isBanco = tipoSelect.value === 'Banco';
            
            // Toggle visibilidad del IBAN
            ibanGroup.style.display = isBanco ? 'block' : 'none';
            entidadGroup.style.display = isBanco ? 'block' : 'none';

            // Marcar IBAN como requerido/no requerido
            if (isBanco) {
                ibanInput.setAttribute('required', 'required');
            } else {
                ibanInput.removeAttribute('required');
            }
        }

        // Ejecutar al cargar la página (para precargar el estado correcto)
        toggleIbanFields(); 

        // NOTA: El campo tipo está deshabilitado en esta vista, por lo que no necesita un listener 'change'.
        // La validación en el backend se asegura de que el IBAN sea requerido si el tipo es 'Banco'.
    });
</script>

@endsection