@extends('layouts.admin')

@section('title','Grid de páginas')
@section('content')

<div class="section-one-col">
    <div class="content-card">
        <h2>Configuración del Grid de Contenidos</h2>
        <p><small>Selecciona qué tipos de contenido se mostrarán automáticamente en la página principal.</small></p>
        <hr><br>

        <form action="{{ route('admin.web.modulos.grid.update') }}" method="POST">
            @csrf
            @method('PUT')

            <div class="section-two-cols">
                {{-- Tipos de Contenido --}}
                <div class="form-group">
                    <label class="form-label">Mostrar en el Grid:</label>
                    <div style="background: #f8fafc; padding: 15px; border-radius: 8px; border: 1px solid #e2e8f0;">
                        @foreach($tiposDisponibles as $key => $label)
                            <label style="display: block; margin-bottom: 10px; cursor: pointer;">
                                <input type="checkbox" name="tipos_permitidos[]" value="{{ $key }}" 
                                    {{ in_array($key, $config->tipos_permitidos ?? []) ? 'checked' : '' }}>
                                <span style="margin-left: 8px;">{{ $label }}</span>
                            </label>
                        @endforeach
                    </div>
                </div>

                {{-- Ajustes de Visualización --}}
                <div>
                    <div class="form-group">
                        <label class="form-label">Título de la Sección</label>
                        <input type="text" name="titulo_seccion" class="form-input" value="{{ $config->titulo_seccion }}" placeholder="Ej: Actualidad, Noticias Recientes...">
                    </div>

                    <div class="form-group">
                        <label class="form-label">Número total de elementos</label>
                        <input type="number" name="cantidad_mostrar" class="form-input" value="{{ $config->cantidad_mostrar }}" min="1" max="20">
                        <p style="font-size: 0.8em; color: #666; margin-top: 5px;">* Se mostrarán los más recientes según esta cantidad.</p>
                    </div>
                </div>
            </div>

            <div style="margin-top: 20px;">
                <button type="submit" class="btn btn-primary">Guardar Configuración</button>
                <a href="{{ route('admin.web.modulos.index') }}" class="btn btn-back">Volver a Módulos</a>
            </div>
        </form>
    </div>
</div>
@endsection