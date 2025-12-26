@extends('layouts.admin')

@section('title', 'Añadir Banner')

@section('content')
<div class="section-one-col">
    <div class="content-card">
        <h2>Añadir Nuevo Banner</h2>
        <hr><br>

        <form action="{{ route('admin.web.modulos.banners.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            
            <div class="section-two-cols" style="gap: 30px;">
                {{-- Izquierda: Datos --}}
                <div>
                    <div class="form-group">
                        <label class="form-label">Título Principal (Opcional)</label>
                        <input type="text" name="titulo" class="form-input" placeholder="Ej: Bienvenidos a nuestra Hermandad">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Subtítulo o descripción corta</label>
                        <input type="text" name="subtitulo" class="form-input" placeholder="Ej: Cultos en honor a nuestros Titulares">
                    </div>
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 10px;">
                        <div class="form-group">
                            <label class="form-label">Texto del Botón</label>
                            <input type="text" name="texto_boton" class="form-input" placeholder="Ej: Leer más">
                        </div>
                        <div class="form-group">
                            <label class="form-label">URL del Botón</label>
                            <input type="text" name="url_boton" class="form-input" placeholder="Ej: /noticias">
                        </div>
                    </div>
                </div>

                {{-- Derecha: Imagen --}}
                <div style="text-align: center; background: #f8fafc; padding: 20px; border-radius: 8px; border: 2px dashed #cbd5e1;">
                    <label class="form-label">Imagen del Banner (Recomendado 1920x800px)</label>
                    <input type="file" name="imagen" id="imgInput" class="form-input" accept="image/*" required>
                    <div style="margin-top: 15px;">
                        <img id="imgPreview" src="#" style="max-width: 100%; height: 150px; object-fit: cover; display: none; border-radius: 4px; box-shadow: 0 4px 6px rgba(0,0,0,0.1);">
                    </div>
                </div>
            </div>

            <div style="margin-top: 30px; display: flex; gap: 10px;">
                <button type="submit" class="btn btn-primary">Guardar Banner</button>
                <a href="{{ route('admin.web.modulos.banners.index') }}" class="btn btn-back">Cancelar</a>
            </div>
        </form>
    </div>
</div>

<script>
    imgInput.onchange = evt => {
        const [file] = imgInput.files;
        if (file) {
            imgPreview.src = URL.createObjectURL(file);
            imgPreview.style.display = 'block';
        }
    }
</script>
@endsection