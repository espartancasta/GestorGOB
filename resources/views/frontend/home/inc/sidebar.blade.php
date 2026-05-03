<div class="gob-sidebar">

    <div class="gob-logo">
        <h4>Investigación</h4>
        <small>Portal Académico</small>
    </div>

    <ul class="gob-menu">

        <li class="{{ request()->routeIs('frontend.home') ? 'active' : '' }}">
            <a href="{{ route('frontend.home') }}">
                Inicio
            </a>
        </li>

        {{-- ACCIÓN PRINCIPAL SEGÚN ROL --}}
        @auth

            {{-- AUTOR --}}
            @if(auth()->user()->role == 1)
                <li class="{{ request()->routeIs('submissions.create') ? 'active' : '' }}">
                    <a href="{{ route('submissions.create') }}">
                        Subir documento
                    </a>
                </li>
            @endif

            {{-- REVISOR --}}
            @if(auth()->user()->role == 2)
                <li class="{{ request()->is('review-invite/my') ? 'active' : '' }}">
                    <a href="{{ url('/review-invite/my') }}">
                        Mis invitaciones
                    </a>
                </li>
            @endif

            {{-- SECRETARIO --}}
            @if(auth()->user()->role == 3)
                <li class="{{ request()->routeIs('submissions.index') ? 'active' : '' }}">
                    <a href="{{ route('submissions.index') }}">
                        Documentos pendientes
                    </a>
                </li>
            @endif

        @else
            <li class="{{ request()->routeIs('auth.login') ? 'active' : '' }}">
                <a href="{{ route('auth.login') }}">
                    Iniciar sesión
                </a>
            </li>
        @endauth

        <li>
            <a href="#">Mis Proyectos</a>
        </li>

        <li>
            <a href="#">Subir Proyecto</a>
        </li>

        <li class="{{ request()->routeIs('frontend.search') ? 'active' : '' }}">
            <a href="{{ route('frontend.search') }}">
                Explorar
            </a>
        </li>

        <li>
            <a href="#">Biblioteca</a>
        </li>

        <li>
            <a href="#">Favoritos</a>
        </li>

        <li>
            <a href="#">Colaboradores</a>
        </li>

    </ul>

</div>