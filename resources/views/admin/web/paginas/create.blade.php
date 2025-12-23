@extends('layouts.admin')

@section('title', 'Crear Nuevo Contenido')

@section('content')
<div class="section-one-col">
    <form action="{{ route('admin.web.paginas.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="content-card">

            <div class="section-two-cols">
                {{-- Columna Principal --}}
                <div class="form-group">
                    <label class="form-label">Contenido (Editor HTML)</label>
                    <textarea id="editor" name="contenido">Aquí el contenido de la noticia, página, comunicado...</textarea>
                </div>

                {{-- Columna Lateral (Ajustes) --}}
                <div>
                    <div class="form-group">
                        <label class="form-label">Título del Post</label>
                        <input type="text" name="titulo" class="form-input" placeholder="Ej: Historia de nuestra corporación" required>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Tipo de Contenido</label>
                        <select name="tipo" class="form-input">
                            @foreach($tipos as $value => $label)
                                <option value="{{ $value }}">{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label class="inline-flex items-center cursor-pointer">
                            <input type="checkbox" name="publicado" value="1" class="sr-only peer" checked>
                            Publicar inmediatamente
                        </label>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Imagen Destacada</label>
                        <input type="file" name="imagen_destacada" class="form-input text-sm">
                    </div>
                </div>
            </div>

            <div class="flex action-buttons-posts">
                <a href="{{ route('admin.web.paginas.index') }}" class="btn btn-back">Cancelar</a>
                <button type="submit" class="btn btn-primary">Guardar Contenido</button>
            </div>

        </div>
    </form>
</div>

{{-- Scripts para el Editor --}}
<script src="https://cdn.tiny.cloud/1/38ns4p8r0kuv9bsp8xmysivmfnrek0xjokgth9mlntxnk2gy/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
<script>
  tinymce.init({
    selector: '#editor',
    plugins: 'anchor autolink charmap codesample emoticons image link lists media searchreplace table visualblocks wordcount',
    toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link image media table | align lineheight | numlist bullist indent outdent | emoticons charmap | removeformat',
    height: 500,
    language: 'es'
  });
</script>
@endsection