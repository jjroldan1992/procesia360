@extends('layouts.admin')

@section('title', 'Editar Banner')

@section('content')
<div class="section-one-col">
    <div class="content-card">

        <form action="{{ route('admin.web.modulos.banners.update', $banner->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            
            <div class="section-two-cols" style="gap: 30px;">
                {{-- Columna Izquierda: Datos --}}
                <div>
                    <div class="form-group">
                        <label class="form-label">Título Principal</label>
                        <input type="text" name="titulo" class="form-input" value="{{ $banner->titulo }}">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Subtítulo</label>
                        <input type="text" name="subtitulo" class="form-input" value="{{ $banner->subtitulo }}">
                    </div>
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 10px;">
                        <div class="form-group">
                            <label class="form-label">Texto del Botón</label>
                            <input type="text" name="texto_boton" class="form-input" value="{{ $banner->texto_boton }}">
                        </div>
                        <div class="form-group">
                            <label class="form-label">URL del Botón</label>
                            <input type="text" name="url_boton" class="form-input" value="{{ $banner->url_boton }}">
                        </div>
                    </div>
                </div>

                {{-- Columna Derecha: Gestión de Imagen --}}
                <div style="text-align: center; background: #f8fafc; padding: 20px; border-radius: 8px; border: 1px solid #e2e8f0;">
                    <label class="form-label">Imagen del Banner</label>
                    
                    <div style="margin-bottom: 15px;">
                        <p style="font-size: 0.8em; color: #666; margin-bottom: 5px;">Imagen actual:</p>
                        <img id="imgPreview" src="{{ asset('storage/' . $banner->imagen_path) }}" 
                             style="max-width: 100%; height: 150px; object-fit: cover; border-radius: 4px; box-shadow: 0 4px 6px rgba(0,0,0,0.1);">
                    </div>

                    <input type="file" name="imagen" id="imgInput" class="form-input" accept="image/*">
                    <p style="font-size: 0.75em; color: #999; mt-2">* Selecciona una imagen solo si deseas cambiar la actual.</p>
                </div>
            </div>

            <div style="margin-top: 30px; display: flex; gap: 10px;">
                <button type="submit" class="btn btn-primary">Actualizar Banner</button>
                <a href="{{ route('admin.web.modulos.banners.index') }}" class="btn btn-back">Cancelar</a>
            </div>
        </form>
    </div>
</div>

<script>
    // Script para previsualizar la nueva imagen antes de subirla
    imgInput.onchange = evt => {
        const [file] = imgInput.files;
        if (file) {
            imgPreview.src = URL.createObjectURL(file);
        }
    }
</script>
@endsection