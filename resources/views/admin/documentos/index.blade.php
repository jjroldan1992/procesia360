@extends('layouts.admin')

@section('title', 'Gestor de archivos')

@section('content')

<style>
    /* Estilo para el item seleccionado */
    .explorer-item.selected {
        background-color: rgba(var(--color-primary-rgb), 0.2) !important;
        border: 1px solid var(--color-primary) !important;
        box-shadow: 0 0 0 2px var(--color-primary-light);
    }
    #btn-bulk-delete {
        display: none; /* Se muestra por JS */
    }
</style>

<div class="section-one-col">
    <div class="content-card" style="overflow-x: auto;">
        <div class="explorer-container">
            <div class="explorer-toolbar flex items-center gap-2">

                <button type="button" class="btn btn-secondary open-offcanvas-btn" data-target="offcanvas-new-folder">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 10v6"/><path d="M9 13h6"/><path d="M20 20a2 2 0 0 0 2-2V8a2 2 0 0 0-2-2h-7.9a2 2 0 0 1-1.69-.9L9.6 3.9A2 2 0 0 0 7.93 3H4a2 2 0 0 0-2 2v13a2 2 0 0 0 2 2Z"/></svg>
                    <span class="texto-en-boton">&nbsp;Nueva carpeta</span>
                </button>
            
                <label class="btn btn-primary cursor-pointer mb-0">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="17 8 12 3 7 8"/><line x1="12" x2="12" y1="3" y2="15"/></svg>
                    <span class="texto-en-boton">&nbsp;Subir archivo</span>
                    <form action="{{ route('documentos.upload') }}" method="POST" enctype="multipart/form-data" id="upload-form">
                        @csrf
                        <input type="hidden" name="current_path" value="{{ $path }}">
                        <input type="file" name="archivo" class="hidden" onchange="document.getElementById('upload-form').submit()" style="display:none">
                    </form>
                </label>

                {{-- BOTÓN ELIMINACIÓN MÚLTIPLE --}}
                <button type="button" id="btn-bulk-delete" class="btn btn-danger" onclick="bulkDelete()">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 6h18"/><path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"/><path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"/></svg>
                    <span class="texto-en-boton">&nbsp;Eliminar seleccionados</span>
                </button>

                <button onclick="changeView('grid')" id="btn-grid" class="btn p-2" title="Vista Cuadrícula">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="7" height="7" x="3" y="3" rx="1"/><rect width="7" height="7" x="14" y="3" rx="1"/><rect width="7" height="7" x="14" y="14" rx="1"/><rect width="7" height="7" x="3" y="14" rx="1"/></svg>
                </button>

                <button onclick="changeView('list')" id="btn-list" class="btn p-2" title="Vista Lista">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="8" x2="21" y1="6" y2="6"/><line x1="8" x2="21" y1="12" y2="12"/><line x1="8" x2="21" y1="18" y2="18"/><line x1="3" x2="3.01" y1="6" y2="6"/><line x1="3" x2="3.01" y1="12" y2="12"/><line x1="3" x2="3.01" y1="18" y2="18"/></svg>
                </button>
                
            </div>

            <div id="explorer-grid" class="explorer-grid view-grid">
                
                @if($path)
                <a 
                    href="{{ route('documentos.index', $parentPath) }}""
                    class="explorer-item folder">
                   
                   <div class="item-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="60" height="60" style="color:gray;" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-folder-output-icon lucide-folder-output"><path d="M2 7.5V5a2 2 0 0 1 2-2h3.9a2 2 0 0 1 1.69.9l.81 1.2a2 2 0 0 0 1.67.9H20a2 2 0 0 1 2 2v10a2 2 0 0 1-2 2H4a2 2 0 0 1-2-1.5"/><path d="M2 13h10"/><path d="m5 10-3 3 3 3"/></svg>
                   </div>
                   <div class="item-name">...</div>
                </a>
                @endif

                @foreach($items as $item)
                    @php 
                        $itemPath = $item->is_file ? ($path ? $path . '/' . $item->name : $item->name) : $item->path;
                        $url = $item->is_file ? $item->url : route('documentos.index', $item->path);
                    @endphp
                    
                    {{-- Usamos div para ambos para controlar mejor el click/dbclick --}}
                    <div class="explorer-item {{ $item->is_file ? 'file' : 'folder' }}" 
                         data-path="{{ $itemPath }}" 
                         data-url="{{ $url }}" 
                         data-is-file="{{ $item->is_file ? 'true' : 'false' }}">
                        
                        <div class="item-icon">
                            @if(!$item->is_file)
                                <svg xmlns="http://www.w3.org/2000/svg" width="60" height="60" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 20a2 2 0 0 0 2-2V8a2 2 0 0 0-2-2h-7.9a2 2 0 0 1-1.69-.9L9.6 3.9A2 2 0 0 0 7.93 3H4a2 2 0 0 0-2 2v13a2 2 0 0 0 2 2Z"/></svg>
                            @else

                                @if ($item->extension == 'pdf')
                                    <div class="item-icon"><svg xmlns="http://www.w3.org/2000/svg" width="60" height="60" style="color:red;" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-file-text-icon lucide-file-text"><path d="M6 22a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h8a2.4 2.4 0 0 1 1.704.706l3.588 3.588A2.4 2.4 0 0 1 20 8v12a2 2 0 0 1-2 2z"/><path d="M14 2v5a1 1 0 0 0 1 1h5"/><path d="M10 9H8"/><path d="M16 13H8"/><path d="M16 17H8"/></svg></div>
                                @elseif ($item->extension == 'jpg' || $item->extension == 'jpeg' || $item->extension == 'png' || $item->extension == 'webp')
                                    <div class="item-icon"><svg xmlns="http://www.w3.org/2000/svg" width="60" height="60" style="color:lightsteelblue;" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-file-image-icon lucide-file-image"><path d="M6 22a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h8a2.4 2.4 0 0 1 1.704.706l3.588 3.588A2.4 2.4 0 0 1 20 8v12a2 2 0 0 1-2 2z"/><path d="M14 2v5a1 1 0 0 0 1 1h5"/><circle cx="10" cy="12" r="2"/><path d="m20 17-1.296-1.296a2.41 2.41 0 0 0-3.408 0L9 22"/></svg></div>
                                @elseif ($item->extension == 'mp3'|| $item->extension == 'wav' || $item->extension == 'aac' || $item->extension == 'ogg' || $item->extension == 'flac' )
                                    <div class="item-icon"><svg xmlns="http://www.w3.org/2000/svg" width="60" height="60" style="color:aquamarine;" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-file-music-icon lucide-file-music"><path d="M11.65 22H18a2 2 0 0 0 2-2V8a2.4 2.4 0 0 0-.706-1.706l-3.588-3.588A2.4 2.4 0 0 0 14 2H6a2 2 0 0 0-2 2v10.35"/><path d="M14 2v5a1 1 0 0 0 1 1h5"/><path d="M8 20v-7l3 1.474"/><circle cx="6" cy="20" r="2"/></svg></div>
                                @elseif ($item->extension == 'pdf')
                                    <div class="item-icon"><svg xmlns="http://www.w3.org/2000/svg" width="60" height="60" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-file-text-icon lucide-file-text"><path d="M6 22a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h8a2.4 2.4 0 0 1 1.704.706l3.588 3.588A2.4 2.4 0 0 1 20 8v12a2 2 0 0 1-2 2z"/><path d="M14 2v5a1 1 0 0 0 1 1h5"/><path d="M10 9H8"/><path d="M16 13H8"/><path d="M16 17H8"/></svg></div>
                                @elseif ($item->extension == 'xlsx' || $item->extension == "xls")
                                    <div class="item-icon"><svg xmlns="http://www.w3.org/2000/svg" width="60" height="60" style="color:rgb(33,115,70);" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-sheet-icon lucide-sheet"><rect width="18" height="18" x="3" y="3" rx="2" ry="2"/><line x1="3" x2="21" y1="9" y2="9"/><line x1="3" x2="21" y1="15" y2="15"/><line x1="9" x2="9" y1="9" y2="21"/><line x1="15" x2="15" y1="9" y2="21"/></svg></div>
                                @elseif ($item->extension == 'docx' || $item->extension == "doc")
                                    <div class="item-icon"><svg xmlns="http://www.w3.org/2000/svg" width="60" height="60" style="color:#01A6F0;" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-book-open-text-icon lucide-book-open-text"><path d="M12 7v14"/><path d="M16 12h2"/><path d="M16 8h2"/><path d="M3 18a1 1 0 0 1-1-1V4a1 1 0 0 1 1-1h5a4 4 0 0 1 4 4 4 4 0 0 1 4-4h5a1 1 0 0 1 1 1v13a1 1 0 0 1-1 1h-6a3 3 0 0 0-3 3 3 3 0 0 0-3-3z"/><path d="M6 12h2"/><path d="M6 8h2"/></svg></div>
                                @endif
    
                            @endif
                        </div>
                        <div class="item-name">{{ $item->name }}</div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

{{-- Formulario oculto para eliminar --}}
<form id="bulk-delete-form" action="{{ route('documentos.destroy') }}" method="POST" style="display:none;">
    @csrf
    @method('DELETE')
    <div id="bulk-delete-inputs"></div>
</form>

<script>

    let selectedItems = new Set();

    document.addEventListener('DOMContentLoaded', function() {

        let lastTap = 0; // Para medir el tiempo entre toques en móvil
        const items = document.querySelectorAll('.explorer-item');
        
        items.forEach(item => {

            item.addEventListener('touchend', function(e) {
                const currentTime = new Date().getTime();
                const tapLength = currentTime - lastTap;
                
                // Si el tiempo entre toques es menor a 300ms, es un doble toque
                if (tapLength < 300 && tapLength > 0) {
                    e.preventDefault(); // Evitamos el zoom del navegador
                    ejecutarApertura(this);
                } else {
                    // Es un toque simple: seleccionamos
                    ejecutarSeleccion(this, e);
                }
                lastTap = currentTime;
            });
            
            // --- MANEJO PARA ESCRITORIO (MOUSE) ---
            item.addEventListener('click', function(e) {
                // En móviles, el click también se dispara, pero touchend ya lo habrá manejado
                // Evitamos duplicidad si es un evento táctil
                if (e.pointerType === 'touch') return; 
                ejecutarSeleccion(this, e);
            });

            item.addEventListener('dblclick', function(e) {
                ejecutarApertura(this);
            });

            // MANEJO DE APERTURA (DOBLE CLICK)
            item.addEventListener('dblclick', function() {
                const url = this.dataset.url;
                const isFile = this.dataset.isFile === 'true';
                
                if (isFile) {
                    window.open(url, '_blank');
                } else {
                    window.location.href = url;
                }
            });
        });

        function ejecutarSeleccion(element, e) {
            // Detectamos si es móvil por el tipo de evento o si el puntero es 'touch'
            const isTouch = e.type.includes('touch') || (e.pointerType === 'touch');

            // Lógica de deselección automática:
            // En PC: Deselecciona si NO pulsas Ctrl/Cmd
            // En Móvil: Solo deselecciona si no hay nada seleccionado aún (el primer toque selecciona, los siguientes suman)
            if (!isTouch && !e.ctrlKey && !e.metaKey) {
                document.querySelectorAll('.explorer-item').forEach(i => i.classList.remove('selected'));
                selectedItems.clear();
            }

            // Toggle de selección
            if (element.classList.contains('selected')) {
                element.classList.remove('selected');
                selectedItems.delete(element.dataset.path);
            } else {
                element.classList.add('selected');
                selectedItems.add(element.dataset.path);
            }

            updateToolbar();
        }

        // Función unificada para abrir
        function ejecutarApertura(element) {
            const url = element.dataset.url;
            const isFile = element.dataset.isFile === 'true';
            
            if (isFile) {
                window.open(url, '_blank');
            } else {
                window.location.href = url;
            }
        }
        
        const savedView = localStorage.getItem('explorer-view');
        if (savedView === 'list') {
            changeView('list');
        }

        // Función para abrir
        const openBtn = document.querySelector('[data-target="offcanvas-new-folder"]');
        const closeBtn = document.querySelector('.close-offcanvas-btn[data-target="offcanvas-new-folder"]');
        const modal = document.getElementById('offcanvas-new-folder');

        if (openBtn && modal) {
            openBtn.addEventListener('click', function() {
                modal.classList.add('active');
                // Foco en el input después de abrir
                setTimeout(() => document.getElementById('folder_name').focus(), 300);
            });
        }

        if (closeBtn && modal) {
            closeBtn.addEventListener('click', function() {
                modal.classList.remove('active');
            });
        }

        // Cerrar al hacer clic fuera (en el overlay)
        modal.addEventListener('click', function(event) {
            if (event.target === modal) {
                modal.classList.remove('active');
            }
        });
    });

    function changeView(type) 
    {
        const grid = document.getElementById('explorer-grid');
        const btnGrid = document.getElementById('btn-grid');
        const btnList = document.getElementById('btn-list');

        if (type === 'list') {
            grid.classList.remove('view-grid');
            grid.classList.add('view-list');
            
            // Estilos botones
            btnList.classList.add('active-view', 'bg-primary');
            btnGrid.classList.remove('active-view', 'bg-primary');
            
            localStorage.setItem('explorer-view', 'list');
        } else {
            grid.classList.remove('view-list');
            grid.classList.add('view-grid');
            
            // Estilos botones
            btnGrid.classList.add('active-view', 'bg-primary');
            btnList.classList.remove('active-view', 'bg-primary');
            
            localStorage.setItem('explorer-view', 'grid');
        }
    }

    function updateToolbar() {
        const btnDelete = document.getElementById('btn-bulk-delete');
        if (selectedItems.size > 0) {
            btnDelete.style.display = 'inline-flex';
        } else {
            btnDelete.style.display = 'none';
        }
    }

    function bulkDelete() {
        if (confirm(`¿Estás seguro de que quieres eliminar los ${selectedItems.size} elementos seleccionados?`)) {
            const form = document.getElementById('bulk-delete-form');
            const container = document.getElementById('bulk-delete-inputs');
            container.innerHTML = '';

            selectedItems.forEach(path => {
                const input = document.createElement('input');
                input.type = 'hidden';
                input.name = 'item_paths[]'; // Enviamos como array
                input.value = path;
                container.appendChild(input);
            });

            form.submit();
        }
    }
</script>

@endsection