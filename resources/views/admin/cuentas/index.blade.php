@extends('layouts.admin')

@section('title', 'Cuentas Contables')

@section('content')

    {{-- Mensajes de Éxito/Error (ej: tras crear o editar) --}}
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    
    <div class="section-one-col">

        <div class="content-card">

            <div class="table-header-controls">

                {{-- Botón de Creación --}}
                <a href="{{ route('cuentas.create') }}" class="btn btn-primary">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-plus"><path d="M5 12h14"></path><path d="M12 5v14"></path></svg>
                    Añadir Cuenta
                </a>
            </div>

            @if($cuentas->isEmpty())
                <p class="text-muted-center" style="padding: 20px;">No se encontraron cuentas contables registradas.</p>
            @else
                {{-- La tabla con la clase 'data-table' --}}
                <table class="data-table">
                    <thead>
                        <tr>
                            {{-- Cabeceras sin ordenamiento dinámico por ahora --}}
                            <th>Nombre</th>
                            <th>Tipo</th>
                            <th>IBAN / Entidad</th>
                            <th class="text-right">Saldo Inicial (€)</th>
                            <th class="text-right">Saldo Actual (€)</th>
                            <th>Activa</th>
                            <th class="text-right">Acciones</th>
                        </tr>
                    </thead>
                    <tbody id="cuentas-table-body">
                        @foreach($cuentas as $cuenta)

                            {{-- Usamos la clase base 'table-row' y atenuamos las inactivas --}}
                            <tr class="{{ !$cuenta->activa ? 'opacity-60 bg-gray-50 dark:bg-gray-700' : '' }}">
                                
                                {{-- Nombre --}}
                                <td data-label="Nombre">
                                    <strong class="text-default">{{ $cuenta->nombre }}</strong>
                                </td>
                                
                                {{-- Tipo --}}
                                <td data-label="Tipo">
                                    <span class="status-badge 
                                        {{ $cuenta->tipo === 'Banco' ? 'status-info' : 'status-success' }}">
                                        {{ $cuenta->tipo }}
                                    </span>
                                </td>
                                
                                {{-- IBAN / Entidad --}}
                                <td data-label="IBAN/Entidad">
                                    @if ($cuenta->tipo === 'Banco')
                                        <strong class="text-default">{{ $cuenta->iban }}</strong><br>
                                        <span class="text-muted">{{ $cuenta->entidad }}</span>
                                    @else
                                        <strong class="text-muted">-</strong>
                                    @endif
                                </td>
                                
                                {{-- Saldo Inicial --}}
                                <td data-label="S. Inicial" class="text-right">
                                    {{ number_format($cuenta->saldo_inicial, 2, ',', '.') }} €
                                </td>
                                
                                {{-- Saldo Actual --}}
                                <td data-label="S. Actual" class="text-right">
                                    <strong class="text-default 
                                        {{ $cuenta->saldo_actual >= 0 ? 'text-success' : 'text-danger' }}">
                                        {{ number_format($cuenta->saldo_actual, 2, ',', '.') }} €
                                    </strong>
                                </td>
                                
                                {{-- Activa --}}
                                <td data-label="Activa">
                                    @if ($cuenta->activa)
                                        <span class="status-badge status-success">Sí</span>
                                    @else
                                        <span class="status-badge status-danger">No</span>
                                    @endif
                                </td>
                                
                                {{-- Acciones --}}
                                <td data-label="Acciones" class="action-buttons-cell">
                                    
                                    {{-- Botón de Edición --}}
                                    <a href="{{ route('cuentas.edit', $cuenta) }}" class="icon-btn" title="Editar">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-pencil"><path d="M17 3a2.85 2.85 0 0 0-4 0L7 13.06l-.55 3.91 3.91-.55L21 7.06a2.85 2.85 0 0 0 0-4Z"></path><path d="m15 5 4 4"></path></svg>
                                    </a>

                                    {{-- Botón de Eliminación
                                    <form action="{{ route('cuentas.destroy', $cuenta) }}" method="POST" class="inline-delete-form">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" onclick="return confirm('¿Está seguro de que desea eliminar la cuenta contable: {{ $cuenta->nombre }}? Advertencia: Si tiene movimientos asociados, esto podría causar errores en el sistema contable.')" class="icon-btn delete-btn" title="Eliminar">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-trash-2"><path d="M3 6h18"></path><path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"></path><path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"></path><line x1="10" x2="10" y1="11" y2="17"></line><line x1="14" x2="14" y1="11" y2="17"></line></svg>
                                        </button>
                                    </form> --}}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
            
            {{-- No hay paginación ya que las cuentas son pocas y se listan todas --}}
        </div>
    </div>

@endsection