@extends('layouts.admin')

@section('title', 'Ajustes de tu '.config('app.cliente_tipo'))

@section('content')

    <div class="section-four-cols">
        
        <div class="content-card configuration-card">

            {{-- 1. Gestión de Tarifas de Cuotas (Enlace al listado) --}}
            <a href="{{ route('config.tarifas.index') }}">
                <div>
                    <svg xmlns="http://www.w3.org/2000/svg" width="36" height="36" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-wallet-icon lucide-wallet"><path d="M19 7V4a1 1 0 0 0-1-1H5a2 2 0 0 0 0 4h15a1 1 0 0 1 1 1v4h-3a2 2 0 0 0 0 4h3a1 1 0 0 0 1-1v-2a1 1 0 0 0-1-1"/><path d="M3 5v14a2 2 0 0 0 2 2h15a1 1 0 0 0 1-1v-4"/></svg>
                </div>
                <div>
                    <h2>Cuotas</h2>
                    <p>Define los precios anuales para las cuotas ordinarias y extraordinarias.</p>
                </div>
            </a>

        </div>

        <div class="content-card configuration-card">

            {{-- 2. Gestión de Cuentas Contables (Ejemplo, usa tu ruta real) --}}
            <a href="{{ route('config.cuentas.index') }}">
                <div>
                    <svg xmlns="http://www.w3.org/2000/svg" width="36" height="36" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-landmark-icon lucide-landmark"><path d="M10 18v-7"/><path d="M11.12 2.198a2 2 0 0 1 1.76.006l7.866 3.847c.476.233.31.949-.22.949H3.474c-.53 0-.695-.716-.22-.949z"/><path d="M14 18v-7"/><path d="M18 18v-7"/><path d="M3 22h18"/><path d="M6 18v-7"/></svg>
                </div>
                <div>
                    <h2>Cuentas Contables</h2>
                    <p>Administra las cuentas contables disponibles (Banco, Caja, etc.).</p>
                </div>
            </a>
            
            {{-- ... (Otras tarjetas de configuración) ... --}}

        </div>
    </div>
@endsection