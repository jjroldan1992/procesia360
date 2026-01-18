<section id="contacto" class="content-section">
    @if ($items->google_maps_script)
    <div id="map">
        <iframe src="{{ $items->google_maps_script }}" width="100%" height="400px" frameborder="0" style="border:0" allowfullscreen></iframe>
    </div>
    @endif
    <div id="contact-content">
        <div class="section-content">
            <div class="row">
                <h3 class="title-contacto"><span>{{ config('app.cliente_nombre') }}</span></h3>
                <p class="info-contacto">{{ $items->direccion }} - {{ $items->municipio }} {{ $items->codigo_postal }} ({{ $items->provincia }})</p>
                <p class="info-contacto"><a href="mailto:{{ $items->email }}">{{ $items->email }}</a></p>
                @if ($items->telefono_whatsapp) <p class="info-contacto">Whatsapp:&nbsp;<a href="https://wa.me/+34{{ $items->telefono_whatsapp }}">{{ $items->telefono_whatsapp }}</a></p>@endif
                @if ($items->url_lista_difusion)<p class="info-contacto"><a href="{{ $items->url_lista_difusion }}">Canal de Difusión</a></p>@endif
            </div>
        </div>
    </div>
</section>