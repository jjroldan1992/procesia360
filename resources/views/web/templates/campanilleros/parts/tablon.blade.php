<section class="tablon-parroquial">
    <h2>Tablón de Avisos</h2>
    <div class="grid-avisos">
        @foreach($avisos as $aviso)
            <div class="aviso-card {{ $aviso->fijado ? 'fijado' : '' }}">
                <h3>{{ $aviso->titulo }}</h3>
                <p>{{ $aviso->contenido }}</p>
                <small>{{ $aviso->tipo }}</small>
            </div>
        @endforeach
    </div>
</section>