@extends('layouts.admin')

@section('title', 'Calendario de eventos')

@section('content')

<div class="section-one-col">
    <div class="content-card">
        <form action="{{ route('admin.web.modulos.calendario.update', $evento->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            
            <div class="section-two-cols">
                <div>
                    <div class="form-group">
                        <label class="form-label">Título del Evento</label>
                        <input type="text" name="titulo" class="form-input" value="{{ $evento->titulo }}" required>
                    </div>

                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 10px;">
                        <div class="form-group">
                            <label class="form-label">Fecha</label>
                            <input type="date" name="fecha" class="form-input" value="{{ $evento->fecha }}" required>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Hora</label>
                            <input type="time" name="hora" class="form-input" value="{{ $evento->hora ? substr($evento->hora, 0, 5) : '' }}">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Tipo de Evento</label>
                        <select name="tipo" class="form-input" required>
                            @foreach($tipos as $key => $label)
                                <option value="{{ $key }}" {{ $evento->tipo == $key ? 'selected' : '' }}>{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Lugar</label>
                        <input type="text" name="lugar" class="form-input" value="{{ $evento->lugar }}">
                    </div>
                </div>

                <div>
                    <div class="form-group">
                        <label class="form-label">Observaciones Adicionales</label>
                        <textarea name="observaciones" class="form-input" rows="5">{{ $evento->observaciones }}</textarea>
                    </div>

                    <div class="form-group" style="background: #f8fafc; padding: 15px; border-radius: 8px; border: 1px solid #e2e8f0;">
                        <label class="form-label">Cartel del Evento</label>
                        @if($evento->cartel_path)
                            <div style="margin-bottom: 10px;">
                                <img id="imgPreview" src="{{ asset('storage/' . $evento->cartel_path) }}" style="max-width: 100%; height: 150px; object-fit: contain; border-radius: 4px;">
                            </div>
                        @endif
                        <input type="file" name="cartel" id="imgInput" class="form-input">
                        <small style="color: #666;">Sube un archivo solo si quieres cambiar el actual.</small>
                    </div>
                </div>
            </div>

            <div style="margin-top: 20px; display: flex; gap: 10px;">
                <button type="submit" class="btn btn-primary">Actualizar Evento</button>
                <a href="{{ route('admin.web.modulos.calendario.index') }}" class="btn btn-back">Cancelar</a>
            </div>
        </form>
    </div>
</div>

<script>
    imgInput.onchange = evt => {
        const [file] = imgInput.files;
        if (file) {
            if(document.getElementById('imgPreview')) {
                document.getElementById('imgPreview').src = URL.createObjectURL(file);
            }
        }
    }
</script>
@endsection