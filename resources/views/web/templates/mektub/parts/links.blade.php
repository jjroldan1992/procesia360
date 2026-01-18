<section id="enlaces" class="content-section">
    <div class="container-links">
        @foreach ($items as $link)
            <div class="link_item">
                <a href="{{ $link->url }}">{{ $link->titulo }}</a>{{ (!$loop->last)? '|' : '' }}
            </div>
        @endforeach
    </div>
    @if (isset($data["redes"]))
        <div class="social-icons-footer">
            @foreach ($data["redes"] as $item)
            <div><a href="{{ $item->url }}"><i class="fa-brands fa-{{ $item->red }}"></i></a></div>
            @endforeach
        </div>
    @endif
    <div class="copyright">
        <div>
            <a href="#">
                <img src="{{ asset('img/logo-procesia360-light.png') }}" alt="Logo ProcesIA 360" class="procesia-footer-logo">
            </a>
        </div>
        <div>© 2025 - 2025 | <b>ProcesIA 360</b> Todos los derechos reservados</div>
    </div>
</section>