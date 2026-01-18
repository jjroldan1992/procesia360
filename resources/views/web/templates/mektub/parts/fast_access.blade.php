<section id="destacado" class="content-section grid">
    <div class="section-heading">
        <h1>Contenido<br><em>destacado</em></h1>
    </div>
    <div class="section-content">
        <div class="owl-carousel owl-theme">
            @foreach($items as $acceso)
            <div class="item">
                <div class="image">
                    <img src="{{ asset('storage/' . $acceso->imagen_path) }}" alt="{{ $acceso->alt_text }}">
                    <div class="destacado-button button">
                        <a href="#projects">Ir al contenido</a>
                    </div>
                </div>
                <!-- <div class="text-content">
                    <h4>{{ $acceso->alt_text }}</h4>
                    <span>Proin et sapien</span>
                    <p>#1 You are allowed to use Sentra Template for your business or client websites. You can use it for commercial or non-commercial or educational purposes.</p>
                </div> -->
            </div>
            @endforeach
        </div>
    </div>
</section>