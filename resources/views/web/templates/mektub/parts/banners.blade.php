<div class="slider">
    <div class="Modern-Slider content-section" id="top">
        @foreach($items as $banner)
        <!-- Item -->
        <div class="item item-{{ $loop->iteration }}">
            <div class="img-fill">
            <div class="image" style="background-image: url({{ asset('storage/' . $banner->imagen_path) }});"></div>
            <div class="info">
                <div>
                    <h1>{{ $banner->titulo }}</h1>
                    <p>{{ $banner->subtitulo }}</p>
                    @if($banner->url_boton)
                        <div class="button">
                            <a href="{{ $banner->url_boton }}">{{ $banner->texto_boton }}</a>
                        </div>
                    @endif
                </div>
                </div>
            </div>
        </div>
        <!-- // Item -->
        @endforeach
    </div>
</div>