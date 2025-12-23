@extends('layouts.admin')

@section('title', 'Configuración de la Web')

@section('content')
<div>
    <form action="{{ route('admin.web.config.update') }}" method="POST" enctype="multipart/form-data">
        @csrf

                <div class="section-two-cols">
                    
                    {{-- SECCIÓN: SEO --}}
                    <div class="content-card">
                        
                        <h3>Presencia en Internet</h3>

                        <div class="form-group">
                            <label>Nombre de la Hermandad (Web)</label>
                            <input class="form-input" type="text" name="nombre_hermandad" value="{{ $settings->nombre_hermandad }}" required>
                        </div>
                        <div class="form-group">
                            <label>Título SEO (Para Google)</label>
                            <input class="form-input" type="text" name="meta_title" value="{{ $settings->meta_title }}">
                        </div>
                        <div class="form-group">
                            <label>Meta Descripción</label>
                            <textarea class="form-input" name="meta_description" rows="2">{{ $settings->meta_description }}</textarea>
                        </div>
                        <div class="form-group">
                            <label>Facebook (URL)</label>
                            <input class="form-input" type="url" name="facebook_url" value="{{ $settings->facebook_url }}">
                        </div>
                        <div class="form-group">
                            <label>Instagram (URL)</label>
                            <input class="form-input" type="url" name="instagram_url" value="{{ $settings->instagram_url }}">
                        </div>

                        <button type="submit" class="btn btn-primary">
                            Guardar Configuración
                        </button>

                    </div>

                    {{-- SECCIÓN: IDENTIDAD --}}
                    <div class="content-card">

                        <h3>Identidad y Diseño</h3>

                        <div class="form-group">
                            <label>Escudo / Logo Oficial</label>
                            @if($settings->logo_path)
                                <img src="{{ asset('storage/' . $settings->logo_path) }}" width="50">
                            @endif
                            <input class="form-input" type="file" name="logo">
                        </div>
                    
                        <div class="form-group">
                            <label>Plantilla Web</label>
                            @foreach([1,2,3] as $tema)
                            <label>
                                <input type="radio" name="tema_id" value="{{ $tema }}" {{ $settings->tema_id == $tema ? 'checked' : '' }}>
                                <span>Plantilla {{ $tema }}</span>
                            </label>
                            @endforeach
                        </div>

                        <div class="form-group">
                            <label>Color Primario</label>
                            <input class="form-input" type="color" name="color_primario" value="{{ $settings->color_primario }}">
                        </div>
                        
                        <div class="form-group">
                            <label>Color Secundario</label>
                            <input class="form-input" type="color" name="color_secundario" value="{{ $settings->color_secundario }}">
                        </div>

                        <button type="submit" class="btn btn-primary">
                            Guardar Configuración
                        </button>
                        
                    </div>

                    {{-- SECCIÓN: MÓDULOS
                    <div class="content-card">
                        <h3>Módulos de la Web</h3>
                        <p>Activa o desactiva las secciones de la página pública.</p>
                        
                        @php
                            $items = [
                                'menu' => 'Menú Principal',
                                'banners' => 'Banners',
                                'acceso_rapido' => 'Acceso Rápido',
                                'calendario' => 'Calendario',
                                'grid' => 'Grid de páginas, noticias, comunicados,...',
                                'social' => 'Redes Sociales',
                                'parroquia' => 'Calendario',
                                'contacto' => 'Formulario de contacto',
                                'link_list' => 'Listado de enlaces'
                            ];
                        @endphp

                        @foreach($items as $key => $label)
                        <div class="form-group">
                            <label>
                                <input type="checkbox" name="mod_{{ $key }}" {{ ($settings->modulos_config[$key] ?? false) ? 'checked' : '' }}>
                            {{ $label }}</label>
                        </div>
                        @endforeach
                        <button type="submit" class="btn btn-primary">
                            Guardar Configuración
                        </button>
                    </div>  --}}

                </div>
    </form>
</div>
@endsection