<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <title>{{ $settings->nombre_hermandad }}</title>

        {{-- Aquí cargaríamos el CSS específico de esta plantilla --}}
        <link rel="stylesheet" href="{{ asset('css/templates/mektub/mektub.css') }}">

        <meta name="description" content="">

        <link rel="apple-touch-icon" href="apple-touch-icon.png">
        <link rel="stylesheet" href="{{ asset('css/templates/mektub/bootstrap.min.css') }}">
        <link rel="stylesheet" href="{{ asset('css/templates/mektub/bootstrap-theme.min.css') }}">
        <link rel="stylesheet" href="{{ asset('css/templates/mektub/fontAwesome.css') }}">
        <link href="{{asset('fontawesome/css/fontawesome.css') }}" rel="stylesheet" />
        <link href="{{asset('fontawesome/css/brands.css') }}" rel="stylesheet" />
        <link href="{{asset('fontawesome/css/solid.css') }}" rel="stylesheet" />
        <link rel="stylesheet" href="{{ asset('css/templates/mektub/light-box.css') }}">
        <link rel="stylesheet" href="{{ asset('css/templates/mektub/owl-carousel.css') }}">
        <link rel="stylesheet" href="{{ asset('css/templates/mektub/templatemo-style.css') }}">
        <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800" rel="stylesheet">
        <script src="{{ asset('js/templates/mektub/vendor/modernizr-2.8.3-respond-1.4.2.min.js') }}"></script>

        <style>

            :root {
                --color_primario: {{ $settings->color_primario }};
                --color_secundario: {{ $settings->color_secundario }};
            }

        </style>
    </head>
    <body>

        @yield('content')

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
        <script src="{{ asset('js/templates/mektub/vendor/jquery-1.11.2.min.js') }}"></script>

        <script src="{{ asset('js/templates/mektub/vendor/bootstrap.min.js') }}"></script>
        
        <script src="{{ asset('js/templates/mektub/plugins.js') }}"></script>
        <script src="{{ asset('js/templates/mektub/main.js') }}"></script>

        <script>
            $(document).ready(function() {
    $('.menu-item-has-children > a').on('click', function(e) {
        e.preventDefault(); // Evita que navegue si es un padre
        
        var $submenu = $(this).next('.sub-menu');
        var $indicator = $(this).find('.submenu-indicator');

        // Cerrar otros submenús abiertos (opcional, estilo acordeón)
        // $('.sub-menu').not($submenu).slideUp();
        // $('.submenu-indicator').not($indicator).removeClass('rotated');

        // Alternar el actual
        $submenu.slideToggle(300);
        $indicator.toggleClass('rotated');
    });
});

            // Hide Header on on scroll down
            var didScroll;
            var lastScrollTop = 0;
            var delta = 5;
            var navbarHeight = $('header').outerHeight();

            $(window).scroll(function(event){
                didScroll = true;
            });

            setInterval(function() {
                if (didScroll) {
                    hasScrolled();
                    didScroll = false;
                }
            }, 250);

            function hasScrolled() {
                var st = $(this).scrollTop();
                
                // Make sure they scroll more than delta
                if(Math.abs(lastScrollTop - st) <= delta)
                    return;
                
                // If they scrolled down and are past the navbar, add class .nav-up.
                // This is necessary so you never see what is "behind" the navbar.
                if (st > lastScrollTop && st > navbarHeight){
                    // Scroll Down
                    $('header').removeClass('nav-down').addClass('nav-up');
                } else {
                    // Scroll Up
                    if(st + $(window).height() < $(document).height()) {
                        $('header').removeClass('nav-up').addClass('nav-down');
                    }
                }
                
                lastScrollTop = st;
            }
        </script>

        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js" type="text/javascript"></script>
        
    </body>
</html>