<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <meta http-equiv="X-UA-Compatible" content="ie=edge"/>
    <link href="https://framework-gb.cdn.gob.mx/gm/v3/assets/images/favicon.ico" rel="shortcut icon">
    <title>@yield('title')</title>
    
    {{-- Estilos Originales --}}
    <link rel="stylesheet" href="{{ asset('assets/frontend/css/bootstrap.min.css') }}"/>
    <link rel="stylesheet" href="{{ asset('assets/frontend/css/owl.carousel.css') }}"/>
    <link rel="stylesheet" href="{{ asset('assets/frontend/css/line-awesome.min.css') }}"/>
    <link rel="stylesheet" href="{{ asset('assets/frontend/css/fontawesome.css') }}"/>
    <link rel="stylesheet" href="{{ asset('assets/frontend/css/style.css') }}"/>
    
    {{-- Sobrescribir estilos gobierno locales --}}
    <link rel="stylesheet" href="{{ asset('assets/frontend/css/estilos-gobmx.css') }}"/>
    
</head>
<body>
    <div class="loader">
        <div class="loader-element"></div>
    </div>

    <x-frontend.header/>

    <main class="page">
        @yield('content')
    </main>

    <x-frontend.footer/>

    <div class="back">
        <a href="#" class="back-top">
            <i class="las la-long-arrow-alt-up"></i>
        </a>
    </div>



    {{-- Scripts --}}
    <script src="{{ asset('assets/frontend/js/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/frontend/js/popper.min.js') }}"></script>
    <script src="{{ asset('assets/frontend/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('assets/frontend/js/theia-sticky-sidebar.js') }}"></script>
    <script src="{{ asset('assets/frontend/js/owl.carousel.min.js') }}"></script>
    <script src="{{ asset('assets/frontend/js/switch.js') }}"></script>
    <script src="{{ asset('assets/frontend/js/jquery.marquee.js') }}"></script>
    <script src="{{ asset('assets/frontend/js/main.js') }}"></script>

    {{-- Script para abrir los enlaces de widgets en nueva pestaña --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.widget a').forEach(function(link) {
                link.setAttribute('target', '_blank');
            });
        });
    </script>

    @yield('script')
</body>
</html>
