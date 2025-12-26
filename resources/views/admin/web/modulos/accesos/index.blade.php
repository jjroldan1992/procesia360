@extends('layouts.admin')

@section('title', 'Accesos Rápidos')

@section('content')
<div class="section-one-col">
    
    @if(session('error'))
        <div style="background: #fee2e2; color: #991b1b; padding: 10px; border-radius: 8px; margin-bottom: 15px;">
            {{ session('error') }}
        </div>
    @endif

    <div class="section-two-cols">
        {{-- Listado de Accesos --}}
        <div class="content-card">
            <h3>Elementos Actuales ({{ \App\Models\FastAccess::count() }}/3)</h3>
            <table class="data-table">
                <thead>
                    <tr>
                        <th></th>
                        <th>Imagen</th>
                        <th>Texto Alt / URL</th>
                        <th style="text-align: right;">Acciones</th>
                    </tr>
                </thead>
                <tbody id="sortable-accesos">
                    @foreach($accesos as $item)
                    <tr data-id="{{ $item->id }}" style="cursor: move;">
                        <td style="color: #ccc;font-size:var(--text-xl);">☰</td>
                        <td>
                            <img src="{{ asset('storage/'.$item->imagen_path) }}" style="width: 80px; height: 50px; object-fit: cover; border-radius: 4px;">
                        </td>
                        <td>
                            <strong>{{ $item->alt_text }}</strong><br>
                            <small>{{ $item->url }}</small>
                        </td>
                        <td style="text-align: right;">
                            <div style="display: flex; justify-content: flex-end; gap: 5px;">
                                <a href="{{ route('admin.web.modulos.accesos.edit', $item->id) }}" class="btn btn-secondary" style="padding: 5px 10px;">Editar</a>
                                <form action="{{ route('admin.web.modulos.accesos.destroy', $item->id) }}" method="POST">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-back" style="padding: 5px 10px;">Eliminar</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{-- Formulario de Creación (Solo si hay menos de 3) --}}
        <div class="content-card">
            @if(\App\Models\FastAccess::count() < 3)
                <h3>Añadir Nuevo Acceso</h3>
                <form action="{{ route('admin.web.modulos.accesos.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label class="form-label">Imagen (Proporción 1:1 o 4:3 recomendada)</label>
                        <input type="file" name="imagen" class="form-input" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Texto Alternativo</label>
                        <input type="text" name="alt_text" class="form-input" placeholder="Ej: Patrimonio de la Hermandad" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">URL de destino</label>
                        <input type="text" name="url" class="form-input" placeholder="Ej: /patrimonio" required>
                    </div>
                    <button type="submit" class="btn btn-primary" style="width: 100%;">Guardar Acceso</button>
                </form>
            @else
                <div style="text-align: center; padding: 40px; color: #666;">
                    <p>Has alcanzado el máximo de 3 accesos rápidos.</p>
                    <small>Elimina uno para poder añadir uno nuevo.</small>
                </div>
            @endif
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>
<script>
    Sortable.create(document.getElementById('sortable-accesos'), {
        animation: 150,
        onEnd: function () {
            let orden = [];
            document.querySelectorAll('#sortable-accesos tr').forEach(el => orden.push(el.dataset.id));
            
            fetch("{{ route('admin.web.modulos.accesos.reorder') }}", {
                method: "POST",
                headers: { "Content-Type": "application/json", "X-CSRF-TOKEN": "{{ csrf_token() }}" },
                body: JSON.stringify({ orden: orden })
            });
        }
    });
</script>
@endsection