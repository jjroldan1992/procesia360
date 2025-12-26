@extends('layouts.admin')

@section('content')
<div class="section-one-col">
    <div class="content-card">
        <h3>Editar Aviso: {{ $aviso->titulo }}</h3>
        <hr><br>

        <form action="{{ route('admin.web.modulos.tablon.update', $aviso->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            
            <div class="section-two-cols">
                <div>
                    <div class="form-group">
                        <label class="form-label">Título</label>
                        <input type="text" name="titulo" class="form-input" value="{{ $aviso->titulo }}" required>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Tipo de Aviso</label>
                        <select name="tipo" class="form-input" required>
                            @foreach($tipos as $val => $text)
                                <option value="{{ $val }}" {{ $aviso->tipo == $val ? 'selected' : '' }}>{{ $text }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Contenido</label>
                        <textarea name="contenido" class="form-input" rows="6" required>{{ $aviso->contenido }}</textarea>
                    </div>
                </div>

                <div>
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 10px;">
                        <div class="form-group">
                            <label class="form-label">Fecha Inicio</label>
                            <input type="date" name="fecha_exposicion" class="form-input" value="{{ $aviso->fecha_exposicion->format('Y-m-d') }}" required>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Fecha Fin</label>
                            <input type="date" name="fecha_finalizacion" class="form-input" value="{{ $aviso->fecha_finalizacion ? $aviso->fecha_finalizacion->format('Y-m-d') : '' }}">
                        </div>
                    </div>

                    <div class="form-group" style="background: #f8fafc; padding: 15px; border-radius: 8px; border: 1px solid #e2e8f0;">
                        <label class="form-label">Documento o Imagen Adjunta</label>
                        @if($aviso->adjunto_path)
                            <div style="margin-bottom: 10px;">
                                <a href="{{ asset('storage/' . $aviso->adjunto_path) }}" target="_blank" class="btn btn-secondary" style="font-size: 12px; padding: 5px 10px;">Ver archivo actual</a>
                            </div>
                        @endif
                        <input type="file" name="adjunto" class="form-input" accept=".pdf,image/*">
                        <small>Sube un archivo nuevo solo si deseas reemplazar el actual.</small>
                    </div>

                    <div class="form-group">
                        <label style="cursor: pointer; display: flex; align-items: center; gap: 8px;">
                            <input type="checkbox" name="fijado" value="1" {{ $aviso->fijado ? 'checked' : '' }}> 
                            <strong>Fijar con chincheta</strong>
                        </label>
                    </div>
                </div>
            </div>

            <div style="margin-top: 20px; display: flex; gap: 10px;">
                <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                <a href="{{ route('admin.web.modulos.tablon.index') }}" class="btn btn-back">Cancelar</a>
            </div>
        </form>
    </div>
</div>
@endsection