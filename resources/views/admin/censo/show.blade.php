@extends('layouts.admin')

@section('title', 'Ficha del Hermano: ' . $hermano->nombre . ' ' . $hermano->apellido)

@section('content')
    <div class="header">
        <h1>Ficha del Hermano</h1>
        <div class="actions">
            <a href="{{ route('censo.index') }}" class="btn-secondary">
                ← Volver al Censo
            </a>
            <a href="{{ route('censo.edit', $hermano) }}" class="btn-primary">
                Editar Ficha
            </a>
        </div>
    </div>

    <div class="ficha-details">
        <h2>{{ $hermano->nombre }} {{ $hermano->apellido }}</h2>
        
        <p><strong>ID de Censo:</strong> {{ $hermano->id }}</p>
        <p><strong>DNI/NIF:</strong> {{ $hermano->dni }}</p>
        
        <hr>
        
        <h3>Datos de Antigüedad</h3>
        <p><strong>Fecha de Alta:</strong> {{ $hermano->fecha_alta->format('d/m/Y') }}</p>
        <p><strong>Antigüedad Total:</strong> {{ $hermano->fecha_alta->diff(Carbon\Carbon::now())->format('%y años, %m meses y %d días') }}</p>
        
        {{-- Aquí irían más datos como domicilio, teléfono, estado de cuotas, etc. --}}
        
        <hr>
        
        <h3>Cuenta de Acceso (Usuario)</h3>
        @if ($hermano->usuario)
            <p>Este hermano tiene una cuenta de usuario activa:</p>
            <ul>
                <li><strong>Email:</strong> {{ $hermano->usuario->email }}</li>
                <li><strong>Rol:</strong> {{ $hermano->usuario->rol->nombre ?? 'N/A' }}</li>
            </ul>
        @else
            <p style="color: #900;">Este Hermano **NO** tiene una cuenta de acceso al sistema (Rol 6).</p>
            {{-- En el futuro, aquí se añadiría el botón "Crear Cuenta de Acceso" --}}
        @endif
    </div>
@endsection