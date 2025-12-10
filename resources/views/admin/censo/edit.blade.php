@extends('layouts.admin')

@section('title', 'Editar Hermano: ' . $hermano->nombre . ' ' . $hermano->apellido)

@section('content')
    <div class="header">
        <h1>Editando a {{ $hermano->nombre }} {{ $hermano->apellido }}</h1>
        <a href="{{ route('censo.index') }}" class="btn-secondary">
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
            
            <div class="form-group">
                <label for="nombre">Nombre:</label>
                {{-- Muestra el valor antiguo si hay error, si no, el valor actual --}}
                <input type="text" id="nombre" name="nombre" value="{{ old('nombre', $hermano->nombre) }}" required>
            </div>

            <div class="form-group">
                <label for="apellido">Apellidos:</label>
                <input type="text" id="apellido" name="apellido" value="{{ old('apellido', $hermano->apellido) }}" required>
            </div>

            <div class="form-group">
                <label for="dni">DNI/NIF:</label>
                <input type="text" id="dni" name="dni" value="{{ old('dni', $hermano->dni) }}" required>
            </div>

            <div class="form-group">
                <label for="fecha_alta">Fecha de Alta:</label>
                {{-- Formateamos la fecha para que el input type="date" la acepte (YYYY-MM-DD) --}}
                <input type="date" id="fecha_alta" name="fecha_alta" value="{{ old('fecha_alta', $hermano->fecha_alta->format('Y-m-d')) }}" required>
            </div>

            <button type="submit" class="btn-submit">
                Guardar Cambios
            </button>
        </form>
    </div>
@endsection