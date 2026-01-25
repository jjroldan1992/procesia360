<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>{{ $settings->nombre_hermandad }}</title>
        {{-- Aquí cargaríamos el CSS específico de esta plantilla --}}
        <link rel="stylesheet" href="{{ asset('css/templates/saeta.css') }}">
        <meta name="robots" content="noindex, nofollow">
    </head>
    <body class="template-saeta">
        <p>Estás usando la plantilla "Saeta"</p>
        <header>
            <img src="{{ asset('storage/' . $settings->escudo_path) }}" alt="Escudo" width="80">
            <h1>{{ $settings->nombre_hermandad }}</h1>
            {{-- Aquí incluirías tu componente de NavMenu --}}
        </header>

        <main>
            @yield('content')
        </main>

        <footer>
            <div class="footer-links">
                @foreach($data['footer_links'] as $link)
                    <a href="{{ $link->url }}">{{ $link->titulo }}</a>
                @endforeach
            </div>
            <div class="footer-social">
                @foreach($data['redes'] as $red)
                    <a href="{{ $red->url }}">{{ $red->red }}</a>
                @endforeach
            </div>
            <p>{{ $data['contacto']->direccion }} - {{ $data['contacto']->municipio }}</p>
        </footer>

    </body>
</html>