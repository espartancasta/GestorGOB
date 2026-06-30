<div class="gob-sidebar author-sidebar">

    <div class="gob-logo author-sidebar-panel">
        <span class="author-panel-icon" aria-hidden="true">
            <i class="las la-clipboard-list"></i>
        </span>
        <div>
            <small>Panel de</small>
            <h4>Autor</h4>
        </div>
    </div>

    @if(!auth()->check() || auth()->user()->role != 1)
        <ul class="gob-menu">
            <li class="{{ request()->routeIs('frontend.home') ? 'active' : '' }}">
                <a href="{{ route('frontend.home') }}">Inicio</a>
            </li>
        </ul>
    @endif

    @auth

        @if(auth()->user()->role == 1)
            <div class="author-sidebar-menu-title">MEN&Uacute; PRINCIPAL</div>

            <ul class="gob-menu author-menu">
                <li class="{{ request()->routeIs('author.convocations', 'submissions.mine') ? 'active' : '' }}">
                    <a href="{{ route('author.convocations') }}">
                        <i class="las la-border-all" aria-hidden="true"></i>
                        <span>
                        Convocatorias
                        </span>
                    </a>
                </li>

                <li class="{{ request()->routeIs('submissions.create') ? 'active' : '' }}">
                    <a href="{{ route('submissions.create') }}">
                        <i class="las la-file-medical" aria-hidden="true"></i>
                        <span>Nueva propuesta</span>
                    </a>
                </li>

                <li class="{{ request()->routeIs('author.submissions.in_process', 'frontend.search') ? 'active' : '' }}">
                    <a href="{{ route('author.submissions.in_process') }}">
                        <i class="las la-clipboard-check" aria-hidden="true"></i>
                        <span>En proceso de evaluaci&oacute;n</span>
                    </a>
                </li>

                <li class="{{ request()->routeIs('author.submissions.completed') ? 'active' : '' }}">
                    <a href="{{ route('author.submissions.completed') }}">
                        <i class="las la-check-circle" aria-hidden="true"></i>
                        <span>Revisi&oacute;n completada</span>
                    </a>
                </li>
            </ul>

            <div class="author-sidebar-footer">
                <span>GestorGOB v2.1.0</span>
                <span>&copy; 2026 Gobierno de M&eacute;xico</span>
            </div>
        @else
            <ul class="gob-menu">
            @if(auth()->user()->role == 2)
                <li class="{{ request()->routeIs('review.invites') ? 'active' : '' }}">
                    <a href="{{ route('review.invites') }}">
                        Revisiones asignadas
                    </a>
                </li>
            @endif

            @if(auth()->user()->role == 3)
                <li class="{{ request()->routeIs('submissions.index') ? 'active' : '' }}">
                    <a href="{{ route('submissions.index') }}">
                        Documentos pendientes
                    </a>
                </li>
            @endif

            @if(auth()->user()->role == 4)
                <li class="{{ request()->routeIs('frontend.home') ? 'active' : '' }}">
                    <a href="{{ route('frontend.home') }}">
                        Revisi&oacute;n final
                    </a>
                </li>
            @endif

            @if(auth()->user()->role != 1)
                <li class="{{ request()->routeIs('messages.index') ? 'active' : '' }}">
                    <a href="{{ route('messages.index') }}">
                        Mensajes
                    </a>
                </li>
            @endif
            </ul>
        @endif

    @endauth

</div>
