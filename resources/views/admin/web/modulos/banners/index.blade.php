@extends('layouts.admin')

@section('title', 'Gestión de Banners')

@section('content')
<div class="section-one-col">

    <div class="content-card">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
            <a href="{{ route('admin.web.modulos.banners.create') }}" class="btn btn-primary">+ Nuevo Banner</a>
        </div>
        <table class="data-table">
            <thead>
                <tr>
                    <th width="30"></th>
                    <th width="150">Imagen</th>
                    <th>Título / Texto</th>
                    <th>Botón / Enlace</th>
                    <th style="text-align: right;">Acciones</th>
                </tr>
            </thead>
            <tbody id="sortable-banners">
                @foreach($banners as $banner)
                <tr data-id="{{ $banner->id }}" style="cursor: move;">
                    <td style="color: #ccc;font-size:var(--text-xl);">☰</td>
                    <td>
                        <img src="{{ asset('storage/' . $banner->imagen_path) }}" style="width: 120px; height: 60px; object-fit: cover; border-radius: 4px; border: 1px solid #ddd;">
                    </td>
                    <td>
                        <strong>{{ $banner->titulo ?? 'Sin título' }}</strong><br>
                        <small style="color: #666;">{{ $banner->subtitulo }}</small>
                    </td>
                    <td>
                        @if($banner->texto_boton)
                            <span style="font-size: 11px; background: #eee; padding: 2px 5px; border-radius: 3px;">
                                {{ $banner->texto_boton }}: {{ $banner->url_boton }}
                            </span>
                        @else
                            <em style="color: #999;">Sin botón</em>
                        @endif
                    </td>
                    <td style="text-align: right;">
                        <div style="display: flex; justify-content: flex-end; gap: 5px;">
                            <a href="{{ route('admin.web.modulos.banners.edit', $banner->id) }}" class="btn btn-secondary">Editar</a>
                            
                            <form action="{{ route('admin.web.modulos.banners.destroy', $banner->id) }}" method="POST" onsubmit="return confirm('¿Eliminar este banner?')">
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
</div>

<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>
<script>
    Sortable.create(document.getElementById('sortable-banners'), {
        animation: 150,
        onEnd: function () {
            let orden = [];
            document.querySelectorAll('#sortable-banners tr').forEach(el => orden.push(el.dataset.id));
            
            fetch("{{ route('admin.web.modulos.banners.reorder') }}", {
                method: "POST",
                headers: { "Content-Type": "application/json", "X-CSRF-TOKEN": "{{ csrf_token() }}" },
                body: JSON.stringify({ orden: orden })
            });
        }
    });
</script>
@endsection