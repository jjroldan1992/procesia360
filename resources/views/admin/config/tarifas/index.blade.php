@extends('layouts.admin')

@section('title', 'Cuotas Anuales')

@section('content')

    <div class="section-one-col">
        <div class="content-card">

            <div class="table-header-controls controles-tabla-dinamica">
                <a href="{{ route('config.index') }}" class="btn btn-back">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-arrow-big-left-dash-icon lucide-arrow-big-left-dash"><path d="M13 9a1 1 0 0 1-1-1V5.061a1 1 0 0 0-1.811-.75l-6.835 6.836a1.207 1.207 0 0 0 0 1.707l6.835 6.835a1 1 0 0 0 1.811-.75V16a1 1 0 0 1 1-1h2a1 1 0 0 0 1-1v-4a1 1 0 0 0-1-1z"/><path d="M20 9v6"/></svg>
                    &nbsp;Configuración
                </a>
                <a href="{{ route('config.tarifas.create') }}" class="btn btn-primary">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-plus"><path d="M5 12h14"/><path d="M12 5v14"/></svg>
                    Añadir Tarifa
                </a>
            </div>

            @if($tarifas->isEmpty())
                <p class="text-muted-center" style="padding: 20px;">Aún no se ha definido ninguna tarifa de cuota.</p>
            @else
                <div class="overflow-x-auto custom-scrollbar">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>Año</th>
                                <th>Cuota Ordinaria (€)</th>
                                <th>Cuota Extraordinaria (€)</th>
                                <th>Activa</th>
                                <th class="text-right">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($tarifas as $tarifa)
                                <tr class="table-row">
                                    <td data-label="Año">
                                        <strong class="text-lg">{{ $tarifa->anio }}</strong>
                                    </td>
                                    <td data-label="Ordinaria">
                                        {{ number_format($tarifa->importe_ordinario, 2, ',', '.') }}
                                    </td>
                                    <td data-label="Extraordinaria">
                                        {{ number_format($tarifa->importe_extraordinario ?? 0, 2, ',', '.') }}
                                    </td>
                                    <td data-label="Activa">
                                        <span class="status-badge {{ $tarifa->activa ? 'status-success' : 'status-danger' }}">
                                            {{ $tarifa->activa ? 'SÍ' : 'NO' }}
                                        </span>
                                    </td>
                                    <td data-label="Acciones" class="action-buttons-cell">
                                        <a href="{{ route('config.tarifas.edit', $tarifa) }}" class="icon-btn" title="Editar">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-pencil"><path d="M17 3a2.85 2.85 0 0 0-4 0L7 13.06l-.55 3.91 3.91-.55L21 7.06a2.85 2.85 0 0 0 0-4Z"></path><path d="m15 5 4 4"></path></svg>
                                        </a>

                                        <form action="{{ route('config.tarifas.destroy', $tarifa) }}" method="POST" class="inline-delete-form">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" onclick="return confirm('¿Está seguro de eliminar la tarifa de {{ $tarifa->anio }}?')" class="icon-btn delete-btn" title="Eliminar">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-trash-2"><path d="M3 6h18"></path><path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"></path><path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"></path><line x1="10" x2="10" y1="11" y2="17"></line><line x1="14" x2="14" y1="11" y2="17"></line></svg>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                
                <div class="pagination-footer">
                    {{ $tarifas->links() }}
                </div>
            @endif
            
        </div>
    </div>
@endsection