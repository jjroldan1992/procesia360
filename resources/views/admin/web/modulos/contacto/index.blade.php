@extends('layouts.admin')
@section('title','Datos de contacto')
@section('content')
<div class="section-one-col">
    <div class="content-card">
        <h2>Configuración de Contacto</h2>
        <hr><br>

        <form action="{{ route('admin.web.modulos.contacto.update') }}" method="POST">
            @csrf
            @method('POST')

            <div class="section-two-cols">
                {{-- Columna Izquierda: Ubicación y Mapa --}}
                <div>
                    <div class="form-group">
                        <label class="form-label">Script de Google Maps (Solo parámetro SRC)</label>
                        <textarea name="google_maps_script" class="form-input" rows="4" placeholder='Introduce solamente el contenido del parámetro src="...."'>{{ $config->google_maps_script }}</textarea>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Dirección (Calle y número)</label>
                        <input type="text" name="direccion" class="form-input" value="{{ $config->direccion }}">
                    </div>

                    <div style="display: grid; grid-template-columns: 1fr 2fr; gap: 10px;">
                        <div class="form-group">
                            <label class="form-label">C.P.</label>
                            <input type="text" name="codigo_postal" class="form-input" value="{{ $config->codigo_postal }}">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Municipio</label>
                            <input type="text" name="municipio" class="form-input" value="{{ $config->municipio }}">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Provincia</label>
                        <input type="text" name="provincia" class="form-input" value="{{ $config->provincia }}">
                    </div>
                </div>

                {{-- Columna Derecha: Comunicación --}}
                <div>
                    <div class="form-group">
                        <label class="form-label">Correo Electrónico Oficial</label>
                        <input type="email" name="email" class="form-input" value="{{ $config->email }}">
                    </div>

                    <div class="form-group">
                        <label class="form-label">Teléfono de Llamadas</label>
                        <input type="text" name="telefono_llamadas" class="form-input" value="{{ $config->telefono_llamadas }}" placeholder="Ej: 957 00 00 00">
                    </div>

                    <div class="form-group" style="background: #f0fdf4; padding: 15px; border-radius: 8px; border: 1px solid #bbf7d0;">
                        <label class="form-label" style="color: #166534;">WhatsApp (Número para chat)</label>
                        <input type="text" name="telefono_whatsapp" class="form-input" value="{{ $config->telefono_whatsapp }}" placeholder="Ej: 600 00 00 00">
                        
                        <label class="form-label" style="color: #166534; margin-top: 15px;">Enlace a Lista de Difusión / Canal</label>
                        <input type="url" name="url_lista_difusion" class="form-input" value="{{ $config->url_lista_difusion }}" placeholder="https://chat.whatsapp.com/...">
                    </div>
                </div>
            </div>

            <div style="margin-top: 25px;">
                <button type="submit" class="btn btn-primary">Guardar Información de Contacto</button>
                <a href="{{ route('admin.web.modulos.index') }}" class="btn btn-back">Volver</a>
            </div>
        </form>
    </div>
</div>
@endsection