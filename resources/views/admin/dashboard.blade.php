@extends('layouts.admin') {{-- Asumimos que más adelante crearás una plantilla base llamada 'layouts.admin' --}}

@section('title', 'Inicio')

@section('content')

    <div class="header">
        <h1>Bienvenido al Panel de Gestión (Junta Directiva)</h1>
    </div>

    <div class="info-box">
        <h2>Detalles del Usuario</h2>
        <p><strong>Correo:</strong> {{ $usuario->email }}</p>
        <p><strong>Rol Asignado:</strong> 
            {{-- Usamos la relación 'rol' del modelo Usuario para obtener el nombre --}}
            <span class="role-badge">{{ $usuario->rol->nombre ?? 'N/A' }} (ID: {{ $usuario->rol_id }})</span>
        </p>
        
        <p>¡Felicidades! Tienes acceso a los módulos de Censo, Cuotas y Tesorería.</p>
    </div>

@endsection