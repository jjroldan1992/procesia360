@extends('layouts.admin')

@section('title', 'Listado de Movimientos')

@section('content')

    <div class="section-one-col">
        <div class="content-card">

            <div class="table-header-controls controles-censo">

                <form action="{{ route('movimientos.index') }}" method="GET" class="search-form" id="search-form-movimientos">
                    <input type="text" name="search" id="search-input-movimientos" placeholder="Buscar concepto o referencia..." class="search-input" value="{{ request('search') }}">
                    <button type="submit" class="search-button">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-search"><circle cx="11" cy="11" r="8"></circle><path d="m21 21-4.3-4.3"></path></svg>
                    </button>
                    {{-- Botón de Filtro de Fecha (Activa el Popup) --}}
                    
                    <button type="button" id="toggle-date-filter" class="icon-btn filter-btn" title="Filtrar por rango de fechas">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-calendar"><rect width="18" height="18" x="3" y="4" rx="2" ry="2"></rect><line x1="16" x2="16" y1="2" y2="6"></line><line x1="8" x2="8" y1="2" y2="6"></line><line x1="3" x2="21" y1="10" y2="10"></line></svg>
                    </button>

                    {{-- POPUP FLOTANTE DE SELECCIÓN DE FECHAS --}}
                    <div id="date-filter-popup" class="filter-popup">
                        <p class="text-default" style="font-weight: bold; margin-bottom: 10px;">Filtrar Rango de Fechas:</p>
                        <div class="form-group">
                            <label for="fecha_inicio" class="text-muted">Desde:</label>
                            <input type="date" name="fecha_inicio" id="fecha_inicio" class="form-input form-input-small" 
                                value="{{ request('fecha_inicio') }}">
                        </div>
                        <div class="form-group">
                            <label for="fecha_fin" class="text-muted">Hasta:</label>
                            <input type="date" name="fecha_fin" id="fecha_fin" class="form-input form-input-small" 
                                value="{{ request('fecha_fin') }}">
                        </div>
                        <button type="submit" class="btn btn-primary btn-block">Aplicar Filtro</button>
                        <button type="button" id="clear-date-filter" class="btn btn-back btn-block">Limpiar</button>
                    </div>
                </form>

                <div class="dashboard-action-buttons">
                    <button type="button" id="add-ingreso-btn-page" class="btn btn-success">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-arrow-up-right"><path d="M7 7h10v10"/><path d="M7 17 17 7"/></svg>
                        Nuevo Ingreso
                    </button>
                    <button type="button" id="add-gasto-btn-page" class="btn btn-danger">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-arrow-down-right-icon lucide-arrow-down-right"><path d="m7 7 10 10"/><path d="M17 7v10H7"/></svg>
                        Nuevo Gasto
                    </button>
                </div>
            </div>

            @if($movimientos->isEmpty())
                <p class="text-muted-center" style="padding: 20px;">No se encontraron movimientos que coincidan con la búsqueda.</p>
            @else
                <div class="overflow-x-auto custom-scrollbar">
                    <table class="data-table">
                        <thead>
                            <tr>
                                @php
                                    // Helper para URLs de ordenamiento (copiado del censo)
                                    $currentSort = request('sort');
                                    $currentDirection = request('direction', 'desc');
                                    
                                    $getSortUrl = function($column) use ($currentSort, $currentDirection) {
                                        $direction = ($currentSort == $column && $currentDirection == 'desc') ? 'asc' : 'desc';
                                        return route('movimientos.index', array_merge(request()->query(), ['sort' => $column, 'direction' => $direction]));
                                    };
                                    
                                    $getSortIcon = function($column) use ($currentSort, $currentDirection) {
                                        if ($currentSort != $column) return '';
                                        return $currentDirection == 'desc' ? ' &darr;' : ' &uarr;'; // Flechas Unicode
                                    };
                                @endphp

                                <th>
                                    <a href="{{ $getSortUrl('fecha') }}" class="sortable-header">Fecha {!! $getSortIcon('fecha') !!}</a>
                                </th>
                                <th>Tipo</th>
                                <th>
                                    <a href="{{ $getSortUrl('concepto') }}" class="sortable-header">Concepto {!! $getSortIcon('concepto') !!}</a>
                                </th>
                                <th>Ref. Doc.</th>
                                <th>
                                    <a href="{{ $getSortUrl('cuenta_contable_id') }}" class="sortable-header">Cuenta</a>
                                </th>
                                <th class="text-right">
                                    <a href="{{ $getSortUrl('cantidad') }}" class="sortable-header">Cantidad (€) {!! $getSortIcon('cantidad') !!}</a>
                                </th>
                                <th class="text-right">Acciones</th>
                            </tr>
                        </thead>
                        <tbody id="movimientos-table-body">
                            @foreach($movimientos as $movimiento)

                                <tr class="table-row">

                                    <td data-label="Fecha">
                                        {{ $movimiento->fecha->format('d/m/Y') }}
                                    </td>

                                    <td data-label="Tipo">
                                        <span class="status-badge 
                                            {{ $movimiento->tipo === 'Ingreso' ? 'status-success' : 'status-danger' }}">
                                            {{ $movimiento->tipo }}
                                        </span>
                                    </td>
                                    
                                    <td data-label="Concepto">
                                        <strong class="text-default">{{ $movimiento->concepto }}</strong>
                                    </td>
                                    
                                    <td data-label="Ref. Doc.">
                                        <span class="text-muted">{{ $movimiento->documento_referencia ?? 'Sin referencia a documento' }}</span>
                                    </td>
                                    
                                    <td data-label="Cuenta">
                                        {{ $movimiento->cuentaContable->nombre }}
                                        <span class="text-muted">({{ $movimiento->cuentaContable->tipo }})</span>
                                    </td>

                                    <td data-label="Cantidad" class="text-right">
                                        <strong class="text-default 
                                            {{ $movimiento->tipo === 'Ingreso' ? 'text-success' : 'text-danger' }}">
                                            {{ $movimiento->tipo === 'Ingreso' ? '+' : '-' }}{{ number_format($movimiento->cantidad, 2, ',', '.') }} €
                                        </strong>
                                    </td>
                                    
                                    <td data-label="Acciones" class="action-buttons-cell">
    
                                        {{-- Botón de Edición (¡MODIFICADO!) --}}
                                        <button type="button" 
                                            class="icon-btn edit-movimiento-btn" 
                                            title="Editar"
                                            data-movimiento="{{ $movimiento->toJson() }}" 
                                            data-update-url="{{ route('movimientos.update', $movimiento) }}"
                                        >
                                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-pencil"><path d="M17 3a2.85 2.85 0 0 0-4 0L7 13.06l-.55 3.91 3.91-.55L21 7.06a2.85 2.85 0 0 0 0-4Z"></path><path d="m15 5 4 4"></path></svg>
                                        </button>
                                    
                                        {{-- Botón de Eliminación (YA EXISTENTE) --}}
                                        <form action="{{ route('movimientos.destroy', $movimiento) }}" method="POST" class="inline-delete-form">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" onclick="return confirm('¿Está seguro de que desea eliminar este movimiento? (El saldo de la cuenta será revertido).')" class="icon-btn delete-btn" title="Eliminar">
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
                    {{ $movimientos->links() }}
                </div>
            @endif
        </div>
    </div>
    
    {{-- Incluimos los modales para poder añadir movimientos desde esta página --}}
    @include('admin.movimientos._modals')

@endsection

{{-- Script para abrir los modales desde esta página --}}
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Enlaces desde los botones en la página de listado
        const addIngresoBtnPage = document.getElementById('add-ingreso-btn-page');
        const addGastoBtnPage = document.getElementById('add-gasto-btn-page');
        const ingresoModal = document.getElementById('ingreso-modal-overlay');
        const gastoModal = document.getElementById('gasto-modal-overlay');

        if (addIngresoBtnPage && ingresoModal) {
            addIngresoBtnPage.addEventListener('click', () => ingresoModal.classList.add('active'));
        }
        
        if (addGastoBtnPage && gastoModal) {
            addGastoBtnPage.addEventListener('click', () => gastoModal.classList.add('active'));
        }
        
        const editModalOverlay = document.getElementById('edit-movimiento-modal-overlay');
        const editForm = document.getElementById('edit-movimiento-form');
        
        // ¡INICIO DE LA VALIDACIÓN!
        if (editModalOverlay && editForm) { 
            
            const closeEditBtns = editModalOverlay.querySelectorAll('.close-offcanvas-btn, .close-modal-btn');
            
            // Cierre del Modal de Edición
            closeEditBtns.forEach(btn => {
                btn.addEventListener('click', () => {
                    editModalOverlay.classList.remove('active');
                });
            });
            
            // Lógica de Edición
            document.querySelectorAll('.edit-movimiento-btn').forEach(button => {
                button.addEventListener('click', function(event) {
                    event.preventDefault();
                    
                    const movimientoData = JSON.parse(this.dataset.movimiento);
                    const updateUrl = this.dataset.updateUrl;

                    // 1. Rellenar los campos del formulario
                    document.getElementById('edit-movimiento-tipo').value = movimientoData.tipo;
                    document.getElementById('edit-concepto').value = movimientoData.concepto;

                    let fechaISO = movimientoData.fecha;
                    let fechaLimpia = fechaISO ? fechaISO.substring(0, 10) : '';

                    document.getElementById('edit-fecha').value = fechaLimpia;
                    
                    document.getElementById('edit-cantidad').value = movimientoData.cantidad;
                    document.getElementById('edit-documento_referencia').value = movimientoData.documento_referencia || '';
                    
                    // Seleccionar la Cuenta Contable correcta
                    document.getElementById('edit-cuenta_contable_id').value = movimientoData.cuenta_contable_id;
                    
                    // 2. Actualizar la acción del formulario
                    editForm.action = updateUrl;
                    
                    // 3. Abrir el modal
                    editModalOverlay.classList.add('active');
                });
            });
        } // ¡FIN DE LA VALIDACIÓN!

        const searchInput = document.getElementById('search-input-movimientos');
        const searchForm = document.getElementById('search-form-movimientos');
        let searchTimeout;

        if (searchInput && searchForm) {
            searchInput.addEventListener('input', function() {
                
                // 1. Limpiar el temporizador anterior
                clearTimeout(searchTimeout);

                // 2. Establecer un nuevo temporizador (ej: 400ms de retraso)
                searchTimeout = setTimeout(function() {
                    
                    // Solo enviamos si hay al menos 2 caracteres o si está vacío (para resetear el filtro)
                    if (searchInput.value.length >= 2 || searchInput.value.length === 0) {
                        searchForm.submit();
                    }
                }, 400); // 400 milisegundos de retraso
            });
            
            // Opcional: Evitar que el ENTER envíe el formulario inmediatamente si ya hay un timeout
            searchForm.addEventListener('keydown', function(event) {
                if (event.key === 'Enter') {
                    event.preventDefault(); // Previene el envío normal
                    clearTimeout(searchTimeout); // Asegura que se ejecuta la búsqueda inmediatamente
                    searchForm.submit();
                }
            });
        }

        // --- LÓGICA DE FILTRADO POR FECHA FLOTANTE ---
        const toggleButton = document.getElementById('toggle-date-filter');
        const popup = document.getElementById('date-filter-popup');
        const clearButton = document.getElementById('clear-date-filter');
        const fechaInicioInput = document.getElementById('fecha_inicio');
        const fechaFinInput = document.getElementById('fecha_fin');
        // Nota: La forma ya está capturada como searchForm
        // const searchForm = document.getElementById('search-form-movimientos'); 

        if (toggleButton && popup) {
            
            // 1. Mostrar/Ocultar el popup
            toggleButton.addEventListener('click', () => {
                popup.classList.toggle('active');
                toggleButton.classList.toggle('active');
            });

            // 2. Cerrar el popup al hacer clic fuera
            document.addEventListener('click', (event) => {
                // Si el clic no fue dentro del popup NI en el botón de toggle
                if (!popup.contains(event.target) && !toggleButton.contains(event.target)) {
                    popup.classList.remove('active');
                    toggleButton.classList.remove('active');
                }
            });

            // 3. Lógica para el botón de Limpiar
            if (clearButton) {
                clearButton.addEventListener('click', () => {
                    // Limpia los campos de fecha
                    fechaInicioInput.value = '';
                    fechaFinInput.value = '';
                    
                    // Envía el formulario para recargar sin filtros de fecha
                    // El resto de filtros (search, sort, direction) se mantienen
                    searchForm.submit();
                });
            }
            
            // 4. Resaltar el botón si hay filtros aplicados al cargar
            if (fechaInicioInput.value || fechaFinInput.value) {
                toggleButton.classList.add('filter-btn-active');
            }
        }
    });
</script>