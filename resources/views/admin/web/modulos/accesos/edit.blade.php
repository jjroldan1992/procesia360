@extends('layouts.admin')

@section('title', 'Accesos rápidos')

@section('content')

<div class="section-one-col">
    <div class="content-card">
        <h2>Editar Acceso Rápido</h2>
        <hr><br>
        <form action="{{ route('admin.web.modulos.accesos.update', $acceso->id) }}" method="POST" enctype="multipart/form-data">
            @csrf @method('PUT')
            
            <div class="section-two-cols">
                <div>
                    <div class="form-group">
                        <label class="form-label">Texto Alternativo</label>
                        <input type="text" name="alt_text" class="form-input" value="{{ $acceso->alt_text }}" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">URL de destino</label>
                        <input type="text" name="url" class="form-input" value="{{ $acceso->url }}" required>
                    </div>
                </div>
                <div style="text-align: center;">
                    <label class="form-label">Imagen Actual</label><br>
                    <img id="imgPreview" src="{{ asset('storage/'.$acceso->imagen_path) }}" style="width: 200px; height: 120px; object-fit: cover; border-radius: 8px; margin-bottom: 10px;">
                    <input type="file" name="imagen" id="imgInput" class="form-input">
                </div>
            </div>

            <div style="margin-top: 20px;">
                <button type="submit" class="btn btn-primary">Actualizar</button>
                <a href="{{ route('admin.web.modulos.accesos.index') }}" class="btn btn-back">Cancelar</a>
            </div>
        </form>
    </div>
</div>

<script>
    imgInput.onchange = evt => {
        const [file] = imgInput.files;
        if (file) { imgPreview.src = URL.createObjectURL(file); }
    }
</script>
@endsection