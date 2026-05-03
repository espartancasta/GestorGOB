<div class="gob-sidebar">

    <div class="gob-logo">
        <h4>Investigación</h4>
        <small>Portal Académico</small>
    </div>

    <ul class="gob-menu">

        <li class="active">Inicio</li>

        {{-- ACCIÓN PRINCIPAL SEGÚN ROL --}}
        @auth

            {{-- AUTOR --}}
            @if(auth()->user()->role == 1)
                <li>
                    <a href="{{ route('submissions.create') }}">
                        Subir documento
                    </a>
                </li>
            @endif

            {{-- REVISOR --}}
            @if(auth()->user()->role == 2)
                <li>
                    <a href="{{ url('/review-invite/my') }}">
                        Mis invitaciones
                    </a>
                </li>
            @endif

            {{-- SECRETARIO --}}
            @if(auth()->user()->role == 3)
                <li>
                    <a href="{{ route('submissions.index') }}">
                        Documentos pendientes
                    </a>
                </li>
            @endif

        @else
            <li>
                <a href="{{ route('auth.login') }}">
                    Iniciar sesión
                </a>
            </li>
        @endauth

        <li>Mis Proyectos</li>
        <li>Subir Proyecto</li>
        <li>Explorar</li>
        <li>Biblioteca</li>
        <li>Favoritos</li>
        <li>Colaboradores</li>

    </ul>

</div>