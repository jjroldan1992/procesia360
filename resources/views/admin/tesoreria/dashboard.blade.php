@extends('layouts.admin')

@section('title', 'Resumen Financiero')

@section('content')

    {{-- Mensajes de Éxito/Error --}}
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    
    <div class="section-one-col">

        <div class="content-card dashboard-header-controls">
            
            {{-- 1. HEADER DE CONTROL Y SALDO TOTAL --}}
            <div>
                <p class="text-muted">Saldo Total de Cuentas Activas</p>
                <h2 class="stat-value-lg 
                    {{ $saldoTotal >= 0 ? 'text-success' : 'text-danger' }}">
                    {{ number_format($saldoTotal, 2, ',', '.') }} €
                </h2>
            </div>
            
            {{-- Botones de Acción (Ingreso/Gasto) --}}
            <div class="dashboard-action-buttons">
                <button type="button" id="add-ingreso-btn" class="btn btn-success">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-arrow-up-right"><path d="M7 7h10v10"/><path d="M7 17 17 7"/></svg>
                    Nuevo Ingreso
                </button>
                <button type="button" id="add-gasto-btn" class="btn btn-danger">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-arrow-down-right-icon lucide-arrow-down-right"><path d="m7 7 10 10"/><path d="M17 7v10H7"/></svg>
                    Nuevo Gasto
                </button>
            </div>
        </div>


        {{-- 2. TARJETAS DE RESUMEN DEL ÚLTIMO MES --}}
        <div class="section-three-cols">
            
            {{-- Ingresos del Mes --}}
            <div class="content-card stat-card-compact">
                <p class="stat-card-title">Ingresos (Últimos 30 días)</p>
                <p class="stat-card-value text-success">
                    +{{ number_format($ingresosMes, 2, ',', '.') }} €
                </p>
            </div>

            {{-- Gastos del Mes --}}
            <div class="content-card stat-card-compact">
                <p class="stat-card-title">Gastos (Últimos 30 días)</p>
                <p class="stat-card-value text-danger">
                    -{{ number_format($gastosMes, 2, ',', '.') }} €
                </p>
            </div>

            {{-- Balance del Mes --}}
            @php $balance = $ingresosMes - $gastosMes; @endphp
            <div class="content-card stat-card-compact">
                <p class="stat-card-title">Balance del Periodo</p>
                <p class="stat-card-value {{ $balance >= 0 ? 'text-default' : 'text-danger' }}">
                    {{ number_format($balance, 2, ',', '.') }} €
                </p>
            </div>
        </div>
        
        {{-- 3. LISTADO DE CUENTAS BANCARIAS Y MOVIMIENTOS RECIENTES --}}
        <div class="section-two-cols">

            {{-- Columna 2 & 3: Movimientos Recientes --}}
            <div class="content-card dashboard-movimientos-recientes">
                <h3 class="card-title-border flex-between">
                    <span>Últimos Movimientos ({{ $movimientosRecientes->count() }} registros)</span>
                    <a href="{{ route('movimientos.index') }}" class="text-primary-link text-sm">Ver listado completo</a>
                </h3>
                
                <ul class="list-unstyled space-y-3">
                    @forelse($movimientosRecientes->take(7) as $movimiento)
                        <li class="list-item-movement">
                            <div class="movement-icon-container">
                                <span @class([
                                    'movement-icon', // Clase base
                                    'bg-success-light' => $movimiento->tipo === 'Ingreso',
                                    'bg-danger-light' => $movimiento->tipo === 'Gasto',
                                ])>
                                    @if ($movimiento->tipo === 'Ingreso')
                                        <svg xmlns="http://www.w3.org/2000/svg" style="color:green;" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-plus-icon lucide-plus"><path d="M5 12h14"/><path d="M12 5v14"/></svg>
                                    @else
                                        <svg xmlns="http://www.w3.org/2000/svg" style="color:red;" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-minus-icon lucide-minus"><path d="M5 12h14"/></svg>
                                    @endif
                                </span>
                                {{-- Concepto y Fecha --}}
                                <div>
                                    <span class="text-default">{{ $movimiento->concepto }}</span>
                                    <p class="text-muted">{{ $movimiento->fecha->format('d/m/Y') }} &middot; {{ $movimiento->cuentaContable->nombre }}</p>
                                </div>
                                
                                @if($movimiento->comprobante_path)
                                    <div>
                                        <a href="{{ asset('storage/' . $movimiento->comprobante_path) }}" target="_blank" class="text-blue-500" title="Ver comprobante">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-paperclip"><path d="m21.44 11.05-9.19 9.19a6 6 0 0 1-8.49-8.49l8.57-8.57A4 4 0 1 1 18 8.84l-8.59 8.51a2 2 0 0 1-2.83-2.83l8.49-8.48"/></svg>
                                        </a>
                                    </div>
                                @endif

                            </div>
                            {{-- Cantidad --}}
                            <span class="text-default font-bold 
                                {{ $movimiento->tipo === 'Ingreso' ? 'text-success' : 'text-danger' }}">
                                {{ $movimiento->tipo === 'Ingreso' ? '+' : '-' }}{{ number_format($movimiento->cantidad, 2, ',', '.') }} €
                            </span>
                        </li>
                    @empty
                        <p class="text-muted-center">No hay movimientos registrados en los últimos 30 días.</p>
                    @endforelse
                </ul>
            </div>

            {{-- Columna 1: Listado de Cuentas (Saldos Individuales) --}}
            <div class="content-card">
                <h3 class="card-title-border">Saldos por Cuenta</h3>
                <ul class="list-unstyled space-y-3">
                    @forelse($cuentas as $cuenta)
                        <li class="list-item-split">
                            <div>
                                <span class="text-default">{{ $cuenta->nombre }}</span>
                                <p class="text-muted">{{ $cuenta->tipo }}</p>
                            </div>
                            <span class="text-default font-bold 
                                {{ $cuenta->saldo_actual >= 0 ? 'text-success' : 'text-danger' }}">
                                {{ number_format($cuenta->saldo_actual, 2, ',', '.') }} €
                            </span>
                        </li>
                    @empty
                         <p class="text-muted">No hay cuentas activas. Añade una para registrar movimientos.</p>
                         <a href="{{ route('config.cuentas.create') }}" class="text-primary-link block-link">Crear cuenta</a>
                    @endforelse
                </ul>
                <div class="content-footer-link">
                    <a href="{{ route('config.cuentas.index') }}" class="text-primary-link">Ver todas las cuentas</a>
                </div>
            </div>

        </div>
    </div>
    
    {{-- AÑADIR MODAL DE INGRESOS Y GASTOS AQUÍ --}}
    @include('admin.movimientos._modals')

@endsection

{{-- Script para abrir los modales (a implementar después) --}}
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const addIngresoBtn = document.getElementById('add-ingreso-btn');
        const addGastoBtn = document.getElementById('add-gasto-btn');
        const ingresoModal = document.getElementById('ingreso-modal-overlay');
        const gastoModal = document.getElementById('gasto-modal-overlay');

        if (addIngresoBtn && ingresoModal) {
            addIngresoBtn.addEventListener('click', () => ingresoModal.classList.add('active'));
        }
        
        if (addGastoBtn && gastoModal) {
            addGastoBtn.addEventListener('click', () => gastoModal.classList.add('active'));
        }
    });
</script>