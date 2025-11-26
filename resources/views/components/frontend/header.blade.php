<header class="header navbar-expand-lg fixed-top">
    <div class="container-fluid">
        <div class="header-area">

           <div class="logo">
    <a href="{{ route('frontend.home') }}">

        @php
            // Seleccionar solo un logo válido
            if (!empty($sitesettings->logo_light) && file_exists(public_path('uploads/logo/'.$sitesettings->logo_light))) {
                $logo = asset('uploads/logo/'.$sitesettings->logo_light);
            } elseif (!empty($sitesettings->logo_dark) && file_exists(public_path('uploads/logo/'.$sitesettings->logo_dark))) {
                $logo = asset('uploads/logo/'.$sitesettings->logo_dark);
            } else {
                $logo = asset('uploads/logo/logo_dark.png');
            }
        @endphp

        <img src="{{ $logo }}" alt="Logo" class="logo-img"/>
    </a>
</div>


            <div class="header-navbar">
                <nav class="navbar">
                    <div class="collapse navbar-collapse" id="main_nav">
                        @if (count($menu) > 0)
                            <ul class="navbar-nav">
                                @foreach ($menu as $item)
                                    <li class="nav-item">
                                        <a class="nav-link{{ request()->url() == $item['href'] ? ' active' : '' }}" 
                                           href="{{ $item['href'] }}">{{ $item['text'] }}</a>
                                    </li>
                                @endforeach
                            </ul>
                        @endif
                    </div>
                </nav>
            </div>

            <div class="header-right">

                <div class="search-icon">
                    <i class="las la-search"></i>
                </div>

                @auth
                    <div class="botton-sub">
                        <a href="{{ route('dashboard.home') }}" class="btn-subscribe">Panel de Control</a>
                    </div>
                @else
                    <div class="botton-sub">
                        <a href="{{ route('auth.login') }}" class="btn-subscribe">Iniciar Sesión</a>
                    </div>
                @endauth

                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#main_nav"
                    aria-expanded="false" aria-label="Mostrar navegación">
                    <span class="navbar-toggler-icon"></span>
                </button>
            </div>

        </div>
    </div>
</header>
