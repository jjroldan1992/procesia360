@extends('layouts.admin')

@section('title', 'Tablón Parroquial')

@section('content')
<div class="section-one-col">
    <div class="section-two-cols">
        
        {{-- Listado de Avisos (El Corcho) --}}
        <div class="content-card">
            <h3>Avisos en el Tablón</h3>
            <div style="display: grid; grid-template-columns: 1fr; gap: 15px;">
                @foreach($avisos as $aviso)
                <div style="padding: 15px; border: 1px solid #e2e8f0; border-radius: 8px; position: relative; background: {{ $aviso->fijado ? '#fffbeb' : '#fff' }}; border-left: 5px solid {{ $aviso->fijado ? '#f59e0b' : '#cbd5e1' }};">
                    @if($aviso->fijado)
                        <span style="position: absolute; top: 10px; right: 10px;">📌</span>
                    @endif
                    <small style="color: #666; text-transform: uppercase; font-weight: bold;">{{ $tipos[$aviso->tipo] }}</small>
                    <h4 style="margin: 5px 0;">{{ $aviso->titulo }}</h4>
                    <p style="font-size: 0.9em; color: #444;">{{ Str::limit($aviso->contenido, 100) }}</p>
                    
                    <div style="margin-top: 10px; display: flex; justify-content: space-between; align-items: center;">
                        <small style="color: #999;">Publicado: {{ $aviso->fecha_exposicion->format('d/m/Y') }}</small>
                        
                        <div style="display: flex; gap: 5px;">
                            <a href="{{ route('admin.web.modulos.tablon.edit', $aviso->id) }}" class="btn btn-secondary">Editar</a>
                            
                            <form action="{{ route('admin.web.modulos.tablon.destroy', $aviso->id) }}" method="POST">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-back" onclick="return confirm('¿Retirar este aviso del tablón?')">Quitar</button>
                            </form>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        {{-- Formulario para colgar aviso --}}
        <div class="content-card">
            <h3>Colgar Nuevo Aviso</h3>
            <form action="{{ route('admin.web.modulos.tablon.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label class="form-label">Título del Aviso</label>
                    <input type="text" name="titulo" class="form-input" required placeholder="Ej: Colecta Extraordinaria">
                </div>

                <div class="form-group">
                    <label class="form-label">Tipo de Aviso</label>
                    <select name="tipo" class="form-input" required>
                        @foreach($tipos as $val => $text)
                            <option value="{{ $val }}">{{ $text }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label class="form-label">Contenido (Breve)</label>
                    <textarea name="contenido" class="form-input" rows="4" required placeholder="Escribe el mensaje aquí..."></textarea>
                </div>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 10px;">
                    <div class="form-group">
                        <label class="form-label">Fecha Inicio</label>
                        <input type="date" name="fecha_exposicion" class="form-input" value="{{ date('Y-m-d') }}" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Fecha Fin (Opcional)</label>
                        <input type="date" name="fecha_finalization" class="form-input">
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label">Adjuntar PDF o Imagen (Opcional)</label>
                    <input type="file" name="adjunto" class="form-input" accept=".pdf,image/*">
                </div>

                <div class="form-group">
                    <label style="cursor: pointer; display: flex; align-items: center; gap: 8px;">
                        <input type="checkbox" name="fijado" value="1"> 
                        <strong>Fijar con chincheta (Siempre arriba)</strong>
                    </label>
                </div>

                <button type="submit" class="btn btn-primary" style="width: 100%;">Colgar en el Tablón</button>
            </form>
        </div>
    </div>
</div>
@endsection