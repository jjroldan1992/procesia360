@extends('layouts.admin')

@section('title','Gestión de Enlaces')

@section('content')
<div class="section-two-cols">
    
    {{-- LISTADO (Izquierda) --}}
    <div class="content-card">
        <h3>Enlaces Actuales</h3>
        <p><small>Arrastra para reordenar o pulsa editar para modificar.</small></p>
        <table class="data-table">
            <thead>
                <tr>
                    <th style="width: 30px;"></th>
                    <th>Título</th>
                    <th style="text-align: right;">Acciones</th>
                </tr>
            </thead>
            <tbody id="sortable-links">
                @foreach($links as $link)
                <tr data-id="{{ $link->id }}" style="cursor: grab;">
                    <td style="color: #ccc;"><span class="handle">☰</span></td>
                    <td>
                        <strong>{{ $link->titulo }}</strong><br>
                        <small style="color: #999;">{{ $link->url }}</small>
                    </td>
                    <td style="text-align: right;">
                        <div style="display: flex; gap: 5px; justify-content: flex-end;">
                            {{-- Botón Editar: Recarga la página con ?edit=ID --}}
                            <a href="{{ route('admin.web.modulos.linklist.index', ['edit' => $link->id]) }}" 
                               class="btn btn-secondary">Editar</a>
                            
                            <form action="{{ route('admin.web.modulos.linklist.destroy', $link->id) }}" method="POST" style="margin:0;">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-back">Eliminar</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    {{-- FORMULARIO DINÁMICO (Derecha) --}}
    <div class="content-card">
        <h3>{{ $link_edit ? 'Editar Enlace' : 'Añadir Nuevo Enlace' }}</h3>
        <hr><br>

        <form action="{{ $link_edit ? route('admin.web.modulos.linklist.update', $link_edit->id) : route('admin.web.modulos.linklist.store') }}" method="POST">
            @csrf
            @if($link_edit) @method('PUT') @endif

            <div class="form-group">
                <label class="form-label">Título del Enlace</label>
                <input type="text" name="titulo" class="form-input" 
                       value="{{ $link_edit ? $link_edit->titulo : old('titulo') }}" 
                       placeholder="Ej: Diócesis de Córdoba" required>
            </div>

            <div class="form-group">
                <label class="form-label">URL (Enlace completo)</label>
                <input type="url" name="url" class="form-input" 
                       value="{{ $link_edit ? $link_edit->url : old('url') }}" 
                       placeholder="https://..." required>
            </div>

            <div class="form-group">
                <button type="submit" class="btn btn-primary">
                    {{ $link_edit ? 'Actualizar Enlace' : 'Añadir al Footer' }}
                </button>
                
                @if($link_edit)
                    <a href="{{ route('admin.web.modulos.linklist.index') }}" class="btn btn-back">Cancelar</a>
                @endif
            </div>
        </form>
    </div>

</div>

{{-- Scripts para Sortable --}}
<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>
<script>
    const el = document.getElementById('sortable-links');
    Sortable.create(el, {
        animation: 150,
        handle: '.handle', // Solo arrastra desde el icono
        ghostClass: 'sortable-ghost',
        onEnd: function() {
            let order = [];
            document.querySelectorAll('#sortable-links tr').forEach((el, index) => {
                order.push({
                    id: el.getAttribute('data-id'),
                    position: index + 1
                });
            });

            // Enviamos el nuevo orden al servidor vía Fetch API
            fetch("{{ route('admin.web.modulos.linklist.reorder') }}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ order: order })
            })
            .then(response => response.json())
            .then(data => {
                console.log('Orden guardado');
            });
        }
    });
</script>

<style>
    .sortable-ghost { opacity: 0.4; background: #f0fdf4; }
    .handle { cursor: grab; font-size: 18px; }
</style>
@endsection