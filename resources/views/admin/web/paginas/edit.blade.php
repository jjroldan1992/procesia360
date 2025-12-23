@extends('layouts.admin')

@section('title', 'Editando: '. $pagina->titulo )

@section('content')
<div class="section-one-col">
    <form action="{{ route('admin.web.paginas.update', $pagina->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT') {{-- ¡Importante para que Laravel sepa que es actualización! --}}
        
        <div class="content-card">

            <div class="section-two-cols">
            
                <div class="form-group">
                    <label class="form-label">Contenido</label>
                    <textarea id="editor" name="contenido">{{ $pagina->contenido }}</textarea>
                </div>

                <div>
                    <div class="form-group">
                        <label class="form-label">Título</label>
                        <input type="text" name="titulo" class="form-input" value="{{ $pagina->titulo }}" required>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">Tipo de Contenido</label>
                        <select name="tipo" class="form-input">
                            <option value="noticia" {{ $pagina->tipo == 'noticia' ? 'selected' : '' }}>Noticia</option>
                            <option value="pagina" {{ $pagina->tipo == 'pagina' ? 'selected' : '' }}>Página Estática</option>
                            <option value="comunicado" {{ $pagina->tipo == 'comunicado' ? 'selected' : '' }}>Comunicado</option>
                            <option value="evento" {{ $pagina->tipo == 'evento' ? 'selected' : '' }}>Evento</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label class="inline-flex items-center cursor-pointer">
                            <input type="checkbox" name="publicado" value="1" class="sr-only peer" {{ $pagina->publicado ? 'checked' : '' }}>
                            <div class="relative w-11 h-6 bg-gray-200 peer-focus:outline-none rounded-full peer peer-checked:bg-primary peer-checked:after:translate-x-full after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border after:rounded-full after:h-5 after:w-5 after:transition-all"></div>
                            <span class="ml-3 text-sm font-medium">Publicado</span>
                        </label>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Imagen Destacada</label>
                        @if($pagina->imagen_destacada)
                            <div style="background-image:url('{{ asset('storage/' . $pagina->imagen_destacada) }}');width:240px;height:240px;background-position:center;background-size:cover;margin-bottom:0.5em" class=""></div>
                        @endif
                        <input type="file" name="imagen_destacada" class="form-input text-sm">
                    </div>              
                </div>

            </div>

            <div class="flex action-buttons-posts">
                <a href="{{ route('admin.web.paginas.index') }}" class="btn btn-back">Volver</a>
                <button type="submit" class="btn btn-primary">Actualizar Cambios</button>
            </div>
            
        </div>
    </form>
</div>

{{-- Cargamos TinyMCE igual que en create.blade.php --}}
<script src="https://cdn.tiny.cloud/1/38ns4p8r0kuv9bsp8xmysivmfnrek0xjokgth9mlntxnk2gy/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
<script>
  tinymce.init({ selector: '#editor', height: 500, language: 'es' });
</script>
@endsection