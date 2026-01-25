<section id="actualidad" class="content-section grid">
    <div class="section-heading">
        <h1>Actualidad:<br><em>Noticias y comunicados</em></h1>
    </div>
    <div class="section-content">
        <div class="owl-carousel owl-theme">
            @foreach($items as $post)
                @if ($post->imagen_destacada != "")
                    <div class="item">
                        <div class="image grid_home_image" style="background-image:url('{{ asset('storage/'.$post->imagen_destacada) }}')"></div>
                        <div class="featured-button button grid_home_button">
                            <a href="{{ url($post->slug) }}">Seguir leyendo</a>
                        </div>
                        <div class="text-content">
                            <h4>{{ $post->titulo }}</h4>
                            <span>Publicado el {{ \Carbon\Carbon::parse($post->fecha_publicacion)->translatedFormat('d') }}
                                de
                                {{ \Carbon\Carbon::parse($post->fecha_publicacion)->translatedFormat('F') }}
                                de
                                {{ \Carbon\Carbon::parse($post->fecha_publicacion)->translatedFormat('Y') }}
                            </span>
                            <p>@php echo substr(strip_tags($post->contenido),0,70); @endphp</p>
                        </div>
                    </div>
                    @endif
            @endforeach
        </div>
    </div>
</section>