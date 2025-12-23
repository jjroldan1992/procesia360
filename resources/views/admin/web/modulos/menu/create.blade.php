@extends('layouts.admin')

@section('title', 'Añadir Enlace al Menú')

@section('content')
<div class="section-one-col">

    <div class="content-card">

        <form action="{{ route('admin.web.modulos.menu.store') }}" method="POST">
            @csrf
            
            <div class="form-group">
                <label class="form-label">Nombre del Enlace (Lo que se verá en la web)</label>
                <input type="text" name="nombre" class="form-input" placeholder="Ej: Historia, Noticias, Contacto..." required>
            </div>

            <div class="form-group">
                <label class="form-label text-blue-800">Enlazar a una Página existente:</label>
                <select onchange="document.getElementById('url_input').value = this.value" class="form-input">
                    <option value="">-- Selecciona una página para copiar su enlace --</option>
                    @foreach($paginas as $pag)
                        <option value="/{{ $pag->slug }}">{{ $pag->titulo }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label class="form-label">URL o Destino</label>
                <input type="text" id="url_input" name="url" class="form-input" placeholder="Ej: /noticias o https://..." required>
                <p style="font-size: 0.8em; color: #666; mt-1">
                    * Puedes escribir una ruta relativa (ej: /historia) o una URL completa.
                </p>
            </div>

            <div class="form-group">
                <label>
                    <input type="checkbox" name="activo" value="1" checked>
                    ¿Mostrar enlace en la web?
                </label>
            </div>

            <div style="display: flex; gap: 10px;">
                <button type="submit" class="btn btn-primary">Guardar Enlace</button>
                <a href="{{ route('admin.web.modulos.menu.index') }}" class="btn btn-back">Cancelar</a>
            </div>
            
        </form>
    </div>
</div>
@endsection