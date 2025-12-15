@extends('layouts.admin')

@section('title', 'Censo de Hermanos')

@section('content')
    
    {{-- Mensajes de Éxito/Error (ej: tras crear o editar) --}}
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    
    <div class="section-one-col">

        <div class="content-card">
            
            <div class="table-header-controls controles-censo">
                
                {{-- Formulario de Búsqueda --}}
                <form method="GET" action="{{ route('censo.index') }}" class="search-form">
                    <input type="text" name="search" placeholder="Buscar por Nombre, DNI o Apellido..." value="{{ request('search') }}" class="search-input">
                    <button type="submit" class="search-button">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-search"><circle cx="11" cy="11" r="8"></circle><path d="m21 21-4.3-4.3"></path></svg>
                    </button>
                </form>
                <div>
                    <button type="button" id="export-listado-btn" class="btn btn-success export-btn">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-file-text"><path d="M15 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7Z"></path><path d="M14 2v4a2 2 0 0 0 2 2h4"></path><path d="M10 9H8"></path><path d="M16 13H8"></path><path d="M16 17H8"></path></svg>
                    &nbsp;Exportar .xls</button>
                    {{-- Botón de Creación --}}
                    <a href="{{ route('censo.create') }}" class="btn btn-primary">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-plus"><path d="M5 12h14"></path><path d="M12 5v14"></path></svg>
                        Añadir Hermano
                    </a>
                </div>
            </div>

            <div id="results-container">
                @include('admin.censo._results', ['hermanos' => $hermanos])
            </div>
            

        </div>
    </div>

    {{-- Modal (Popup) de Opciones de Exportación --}}
    <div id="export-modal-overlay" class="offcanvas-overlay">
        <div id="export-modal" class="offcanvas-panel" style="max-width: 325px; padding: 20px;">
            
            <div class="offcanvas-title">
                <h3>Opciones de Exportación</h3>
                <button type="button" id="close-export-modal" class="close-offcanvas-btn">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-x"><path d="M18 6 6 18"></path><path d="m6 6 12 12"></path></svg>
                </button>
            </div>
            
            <p class="text-muted" style="font-size: var(--text-sm); margin-bottom: 1.5rem;">Selecciona el tipo de filtro para tu exportación a Excel (.xlsx).</p>

            {{-- Formulario REAL de Exportación --}}
            <form method="GET" action="{{ route('censo.export') }}" target="_blank"> 
                
                <div class="form-group">
                    <label for="export_type" class="mb-2" style="font-weight: bold;">Filtrar por Estado:</label>
                    
                    {{-- Opciones Comunes del Censo --}}
                    <div class="checkbox-group" style="margin-top: 10px;">
                        
                        {{-- Filtro: Hermanos Activos --}}
                        <label class="checkbox-container">
                            <input type="radio" name="filter_type" value="completo" checked>
                            Listado completo
                            <span class="checkmark"></span>
                        </label>

                        {{-- Filtro: Hermanos Activos --}}
                        <label class="checkbox-container">
                            <input type="radio" name="filter_type" value="activos">
                            Hermanos actuales
                            <span class="checkmark"></span>
                        </label>
                        
                        {{-- Filtro: Hermanos de Baja --}}
                        <label class="checkbox-container">
                            <input type="radio" name="filter_type" value="baja">
                            Dados de baja
                            <span class="checkmark"></span>
                        </label>

                        {{-- Filtro: Listado de Difuntos (Fallecidos) --}}
                        <label class="checkbox-container">
                            <input type="radio" name="filter_type" value="difuntos">
                            Difuntos de la {{ config('app.cliente_tipo') }}
                            <span class="checkmark"></span>
                        </label>
                    </div>
                </div>

                {{-- Opciones Relacionadas con Tesorería (Futuro) --}}
                <div class="form-group" style="border-top: 1px solid var(--border-color); padding-top: 1rem; margin-top: 1rem;">
                    <label for="export_type" class="mb-2" style="font-weight: bold;">Filtrar por Tesorería:</label>
                    
                    <div class="checkbox-group" style="margin-top: 10px;">
                        
                        {{-- Filtro: Hermanos con Cuotas Pendientes (Necesario en Tesorería) --}}
                        <label class="checkbox-container">
                            <input type="radio" name="filter_type" value="cuotas_pendientes">
                            Hermanos con cuotas pendientes
                            <span class="checkmark"></span>
                        </label>
                        
                        {{-- Filtro: Solo Menores de Edad --}}
                        <label class="checkbox-container">
                            <input type="radio" name="filter_type" value="menores_edad">
                            Hermanos menores de edad
                            <span class="checkmark"></span>
                        </label>
                    </div>
                </div>

                <div class="form-actions" style="justify-content: flex-end;">
                    <button type="button" class="btn btn-back" id="cancel-export-modal">Cancelar</button>
                    <button type="submit" class="btn btn-secondary">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-file-text"><path d="M15 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7Z"></path><path d="M14 2v4a2 2 0 0 0 2 2h4"></path></svg>
                        &nbsp;Descargar .xls
                    </button>
                </div>
            </form>

        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {

            // --- Lógica del Modal de Exportación ---
            const exportBtn = document.getElementById('export-listado-btn');
            const exportModalOverlay = document.getElementById('export-modal-overlay');
            const closeExportBtn = document.getElementById('close-export-modal');
            const cancelExportBtn = document.getElementById('cancel-export-modal');

            function toggleExportModal(show) {
                if (show) {
                    exportModalOverlay.classList.add('active');
                } else {
                    exportModalOverlay.classList.remove('active');
                }
            }

            if (exportBtn && exportModalOverlay) {
                // Abrir modal
                exportBtn.addEventListener('click', () => toggleExportModal(true));
                
                // Cerrar modal (botón X, Cancelar, o clic en el overlay)
                [closeExportBtn, cancelExportBtn, exportModalOverlay].forEach(element => {
                    if (element) {
                        element.addEventListener('click', (e) => {
                            // Asegurar que solo el overlay o los botones cierren el modal
                            if (e.target === exportModalOverlay || e.target === closeExportBtn || e.target === cancelExportBtn) {
                                toggleExportModal(false);
                            }
                        });
                    }
                });

                // Detener la propagación del clic dentro del panel para que no se cierre
                document.getElementById('export-modal').addEventListener('click', (e) => {
                    e.stopPropagation();
                });
            }

            const searchInput = document.querySelector('.search-input');
            const resultsContainer = document.getElementById('results-container');
            let timeoutId;

            // Función principal que hace la llamada AJAX
            function fetchResults(searchTerm) {
                // Construimos la URL con el término de búsqueda
                const url = `{{ route('censo.index') }}?search=${encodeURIComponent(searchTerm)}`;
                
                fetch(url, {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest' // Informa a Laravel que es una petición AJAX
                    }
                })
                .then(response => response.text())
                .then(html => {
                    // Reemplazamos el contenido del contenedor con el nuevo HTML
                    resultsContainer.innerHTML = html;
                })
                .catch(error => {
                    console.error('Error al realizar la búsqueda AJAX:', error);
                });
            }

            // Evento que se dispara al soltar la tecla
            searchInput.addEventListener('keyup', (e) => {
                // 1. Cancelar cualquier búsqueda pendiente (para no saturar el servidor)
                clearTimeout(timeoutId);

                // 2. Definir un pequeño retraso (ej. 300ms) para esperar a que el usuario termine de escribir
                timeoutId = setTimeout(() => {
                    fetchResults(searchInput.value);
                }, 300); // 300ms de retraso
            });
            
            // Opcional: Evitar que el formulario recargue la página si el usuario presiona Enter
            const searchForm = document.querySelector('.search-form');
            if (searchForm) {
                searchForm.addEventListener('submit', (e) => {
                    e.preventDefault();
                    fetchResults(searchInput.value);
                });
            }
        });
    </script>
</body>
@endsection