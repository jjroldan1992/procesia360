<section id="tablon" class="content-section">
    <div class="section-heading">
        <h1>Tablón<br><em>Parroquial</em></h1>
    </div>
    <div class="section-content">
        <div class="masonry">
            <div class="row noticias_tablon">
                @foreach ($items as $noticia)
                    <div class="item noticia_tablon">
                        <h2 class="noticia_titulo">{{ $noticia->titulo }}</h2>
                        <p class="noticia_contenido">{{ $noticia->contenido }}</p>
                        @if ($noticia->adjunto_path != NULL)
                        <a target="_blank" href="{{ asset('storage/'.$noticia->adjunto_path) }}" alt="{{ $noticia->titulo }}">
                            <img src="{{ asset('storage/'.$noticia->adjunto_path) }}" alt="{{ $noticia->titulo }}">
                        </a>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>
    </div>            
</section>