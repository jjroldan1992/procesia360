@extends('layouts.admin')

@section('title', 'Editar Hermano: ' . $hermano->nombre . ' ' . $hermano->apellido)

@section('content')
<div class="section-one-col">
        
    <div class="form-container content-card">
            
        <div class="card-header">
            <h1>Editando a {{ $hermano->nombre }} {{ $hermano->apellido }}</h1>
            <a href="{{ route('censo.index') }}" class="btn btn-secondary">
                ← Volver al Censo
            </a>
        </div>

        <div class="form-container">
        
            {{-- Manejo de Errores de Validación --}}
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- El formulario apunta a la ruta 'censo.update', usando el ID del Hermano --}}
            <form method="POST" action="{{ route('censo.update', $hermano) }}">
                @csrf
                {{-- CRUCIAL: Usar el método PUT/PATCH para la actualización RESTful --}}
                @method('PUT') 

                <div class="section-four-cols">
                
                    <div class="form-group">
                        <label for="nombre">Nombre:</label>
                        {{-- Muestra el valor antiguo si hay error, si no, el valor actual --}}
                        <input class="form-input" type="text" id="nombre" name="nombre" value="{{ old('nombre', $hermano->nombre) }}" required>
                    </div>

                    <div class="form-group">
                        <label for="apellido">Apellidos:</label>
                        <input class="form-input" type="text" id="apellido" name="apellido" value="{{ old('apellido', $hermano->apellido) }}" required>
                    </div>

                    <div class="form-group">
                        <label for="dni">DNI/NIF:</label>
                        <input class="form-input" type="text" id="dni" name="dni" value="{{ old('dni', $hermano->dni) }}" required>
                    </div>

                    <div class="form-group">
                        <label for="domicilio_calle">Calle / Vía</label>
                        <input type="text" name="domicilio_calle" id="domicilio_calle" class="form-input" 
                               value="{{ old('domicilio_calle', $hermano->domicilio_calle) }}">
                        @error('domicilio_calle')<span class="text-danger">{{ $message }}</span>@enderror
                    </div>
        
                    <div class="form-group">
                        <label for="domicilio_numero">Número, Piso, Puerta</label>
                        <input type="text" name="domicilio_numero" id="domicilio_numero" class="form-input" 
                               value="{{ old('domicilio_numero', $hermano->domicilio_numero) }}">
                        @error('domicilio_numero')<span class="text-danger">{{ $message }}</span>@enderror
                    </div>

                    <div class="form-group">
                        <label for="domicilio_poblacion">Población / Municipio</label>
                        <input type="text" name="domicilio_poblacion" id="domicilio_poblacion" class="form-input" 
                               value="{{ old('domicilio_poblacion', $hermano->domicilio_poblacion) }}" required>
                        @error('domicilio_poblacion')<span class="text-danger">{{ $message }}</span>@enderror
                    </div>
        
                    <div class="form-group">
                        <label for="domicilio_cp">Código Postal</label>
                        <input type="text" name="domicilio_cp" id="domicilio_cp" class="form-input" 
                               value="{{ old('domicilio_cp', $hermano->domicilio_cp) }}">
                        @error('domicilio_cp')<span class="text-danger">{{ $message }}</span>@enderror
                    </div>
        
                    <div class="form-group">
                        <label for="domicilio_provincia">Provincia</label>
                        <input type="text" name="domicilio_provincia" id="domicilio_provincia" class="form-input" 
                               value="{{ old('domicilio_provincia', $hermano->domicilio_provincia) }}" required>
                        @error('domicilio_provincia')<span class="text-danger">{{ $message }}</span>@enderror
                    </div>

                    <div class="form-group">
                        <label for="fecha_alta">Fecha de Alta:</label>
                        {{-- Formateamos la fecha para que el input type="date" la acepte (YYYY-MM-DD) --}}
                        <input class="form-input" type="date" id="fecha_alta" name="fecha_alta" value="{{ old('fecha_alta', $hermano->fecha_alta->format('Y-m-d')) }}" required>
                    </div>

                    {{-- Columna Fecha de Baja --}}
                    <div class="form-group">
                        <label for="fecha_baja">Fecha de Baja / Fallecimiento (opcional)</label>
                        <input type="date" name="fecha_baja" id="fecha_baja" class="form-input" 
                                value="{{ old('fecha_baja', $hermano->fecha_baja?->format('Y-m-d')) }}">
                        @error('fecha_baja')<span class="text-danger">{{ $message }}</span>@enderror
                    </div>
                
                    {{-- Columna Fallecido (Checkbox) --}}
                    <div class="form-group" style="padding-top: 1.8rem;">
                        <label class="checkbox-container">
                            <input type="checkbox" name="fallecido" 
                                    value="1" 
                                    {{ old('fallecido', $hermano->fallecido) ? 'checked' : '' }}>
                            Hermano Fallecido
                            <span class="checkmark"></span>
                        </label>
                        @error('fallecido')<span class="text-danger">{{ $message }}</span>@enderror
                    </div>
                </div>
                <div class="form-actions">
                    <button type="submit" class="btn btn-primary btn-submit" style="width:100%">
                        Guardar Cambios
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
