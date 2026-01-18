@extends('web.templates.mektub.layout')

@section('content')


@if(isset($data['menu']))
        @include('web.templates.mektub.parts.menu', ['items' => $data['menu']])
    @endif

<div class="page-content">
    <section class="content-section">
        <div class="section-heading">
            <h1>{{ $post->titulo }}</h1>
            @if($post->tipo == 'noticia')
                <span>Publicado el {{ \Carbon\Carbon::parse($post->fecha_publicacion)->translatedFormat('d \d\e F \d\e Y') }}</span>
            @endif
        </div>
        
        <div class="section-content">
            @if($post->imagen_destacada)
                <div class="post-featured-image" style="margin-bottom: 30px;">
                    <img src="{{ asset('storage/' . $post->imagen_destacada) }}" alt="{{ $post->titulo }}" style="width: 100%; border-radius: 5px;">
                </div>
            @endif

            <div class="post-body-content" style="color: #444; line-height: 1.8; font-size: 1.1em;">
                {!! $post->contenido !!} {{-- Usamos {!! !!} porque el contenido viene del editor HTML --}}
            </div>

            <div style="margin-top: 50px;">
                <a href="{{ route('web.home') }}" class="btn btn-primary" style="background: var(--color_secundario); color: white; padding: 10px 20px; text-decoration: none; border-radius: 3px;">
                    <i class="fa fa-arrow-left"></i> Volver al inicio
                </a>
            </div>
        </div>
    </section>

    @if(isset($data['contacto']))
        @include('web.templates.mektub.parts.contacto', ['items' => $data["contacto"]])
    @endif

    @if(isset($data['footer_links']))
        @include('web.templates.mektub.parts.links', ['items' => $data["footer_links"]])
    @endif

</div>
@endsection