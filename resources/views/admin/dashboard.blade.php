@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
    
    {{-- Banner Superior (Replicando el fondo azul/cian con gradiente) --}}
    <div class="welcome-banner">
        <h2>¡Bienvenido de nuevo, {{ Auth::user()->nombre }}!</h2>
        <p>Aquí tienes un pequeño resumen sobre tu {{ config('app.cliente_tipo') }}.</p>
    </div>

    {{-- ============================================= --}}
    {{-- 1. Métricas Clave (Key Statistics) --}}
    {{-- ============================================= --}}
    <div class="key-stats-container">
        
        {{-- Tarjeta 1: Total de Hermanos --}}
        <div class="stat-card">
            <div>
                <p class="stat-card-title">Total de Hermanos</p>
                <p class="stat-card-value">{{ \App\Models\Hermano::count() }}</p>
            </div>
            <div class="stat-icon"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-user-2"><path d="M14 19a4 4 0 0 0-8 0"></path><path d="M12 4a4 4 0 0 0-4 4a4 4 0 0 0 4 4a4 4 0 0 0 4-4a4 4 0 0 0-4-4"></path></svg></div>
        </div>

        {{-- Tarjeta 2: Hermanos al Día en Cuotas (Ejemplo) --}}
        <div class="stat-card">
            <div>
                <p class="stat-card-title">Cuotas al Día</p>
                <p class="stat-card-value">XX</p> {{-- Se calculará con el módulo de Tesorería --}}
            </div>
            <div class="stat-icon"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-check-circle"><path d="M22 11.08V12a10 10 0 1 1-5.46-9.15"></path><path d="m9.2 14.8 2.2 2.2 4.6-4.6"></path></svg></div>
        </div>
        
        {{-- (Añadir más tarjetas según necesidad...) --}}

    </div>

    {{-- ============================================= --}}
    {{-- 2. Secciones Principales (Notificaciones / Acciones) --}}
    {{-- ============================================= --}}
    <div class="section-two-cols">
        
        {{-- Columna Izquierda (Notificaciones Recientes) --}}
        <div class="content-card">
            <h3>Notificaciones Recientes</h3>
            <p style="color: var(--color-text-muted);">Aquí aparecerán los avisos (ej: Cuota impagada, Documento pendiente).</p>
            {{-- (Aquí iría el HTML para la lista de notificaciones) --}}
        </div>
        
        {{-- Columna Derecha (Acciones Rápidas) --}}
        <div class="content-card">
            <h3>Acciones Rápidas</h3>
            
            <div class="action-list">
                <a href="{{ route('censo.create') }}" class="btn btn-primary" style="display: block; margin-bottom: 10px;">
                    + Añadir Nuevo Hermano
                </a>
                <a href="#" class="btn btn-secondary" style="display: block; margin-bottom: 10px;">
                    Gestionar Cuotas
                </a>
                <a href="{{ route('censo.create') }}" class="btn btn-primary" style="display: block; margin-bottom: 10px;">
                    + Añadir Nuevo Hermano
                </a>
                <a href="#" class="btn btn-danger" style="display: block; margin-bottom: 10px;">
                    Gestionar Cuotas
                </a>
                <a href="{{ route('censo.create') }}" class="btn btn-warning" style="display: block; margin-bottom: 10px;">
                    + Añadir Nuevo Hermano
                </a>
                <a href="{{ route('censo.create') }}" class="btn btn-success" style="display: block; margin-bottom: 10px;">
                    + Añadir Nuevo Hermano
                </a>
            </div>
        </div>
        
    </div>

@endsection