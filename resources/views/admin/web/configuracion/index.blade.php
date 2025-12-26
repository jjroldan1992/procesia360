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
                            <label class="form-label">Plantilla Visual de la Web</label>
                            <select name="template" class="form-input">
                                <option value="campanilleros" {{ $settings->template == 'campanilleros' ? 'selected' : '' }}>Campanilleros (Tradicional)</option>
                                <option value="saeta" {{ $settings->template == 'saeta' ? 'selected' : '' }}>Saeta (Solemne)</option>
                                <option value="mektub" {{ $settings->template == 'mektub' ? 'selected' : '' }}>Mektub (Moderna/Vanguardista)</option>
                            </select>
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