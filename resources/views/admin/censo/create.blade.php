@extends('layouts.admin')

@section('title', 'Añadir Nuevo Hermano')

@section('content')
    <div class="header">
        <h1>Crear Registro de Hermano</h1>
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

        {{-- El formulario apunta a la ruta 'censo.store' (POST /censo) --}}
        <form method="POST" action="{{ route('censo.store') }}">
            @csrf
            
            <div class="form-group">
                <label for="nombre">Nombre:</label>
                <input type="text" id="nombre" name="nombre" value="{{ old('nombre') }}" required>
            </div>

            <div class="form-group">
                <label for="apellido">Apellidos:</label>
                <input type="text" id="apellido" name="apellido" value="{{ old('apellido') }}" required>
            </div>

            <div class="form-group">
                <label for="dni">DNI/NIF:</label>
                <input type="text" id="dni" name="dni" value="{{ old('dni') }}" required>
            </div>

            <div class="form-group">
                <label for="fecha_alta">Fecha de Alta (en la Hermandad):</label>
                <input type="date" id="fecha_alta" name="fecha_alta" value="{{ old('fecha_alta', date('Y-m-d')) }}" required>
            </div>
            
            <p style="margin-top: 25px;">
                <small>Nota: La cuenta de acceso (Usuario) se puede enlazar después.</small>
            </p>

            <button type="submit" class="btn-submit">
                Guardar Hermano
            </button>
        </form>
    </div>
@endsection