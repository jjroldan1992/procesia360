@extends('layouts.admin')

@section('title', 'Editar Enlace')

@section('content')
<div class="section-one-col">
    <div class="content-card">
        <h2 class="mb-4">Editando: {{ $menu->nombre }}</h2>
        <hr><br>

        <form action="{{ route('admin.web.modulos.menu.update', $menu->id) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div style="margin-bottom: 15px;">
                <label class="form-label">Nombre del Enlace</label>
                <input type="text" name="nombre" class="form-input" value="{{ $menu->nombre }}" required>
            </div>

            <div style="margin-bottom: 15px; padding: 10px; background: #f0f7ff; border-radius: 5px;">
                <label class="form-label text-blue-800">Cambiar a otra Página:</label>
                <select onchange="document.getElementById('url_input').value = this.value" class="form-input">
                    <option value="">-- Selecciona para cambiar la URL --</option>
                    @foreach($paginas as $pag)
                        <option value="/{{ $pag->slug }}" {{ $menu->url == '/'.$pag->slug ? 'selected' : '' }}>{{ $pag->titulo }}</option>
                    @endforeach
                </select>
            </div>

            <div style="margin-bottom: 15px;">
                <label class="form-label">URL / Destino</label>
                <input type="text" id="url_input" name="url" class="form-input" value="{{ $menu->url }}" required>
            </div>

            <div style="margin-bottom: 20px;">
                <label>
                    <input type="checkbox" name="activo" value="1" {{ $menu->activo ? 'checked' : '' }}>
                    ¿Mostrar enlace en la web?
                </label>
            </div>

            <div style="display: flex; gap: 10px;">
                <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                <a href="{{ route('admin.web.modulos.menu.index') }}" class="btn btn-back">Cancelar</a>
            </div>
        </form>
    </div>
</div>
@endsection