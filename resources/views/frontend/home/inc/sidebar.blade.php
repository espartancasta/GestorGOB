<div class="gob-sidebar author-sidebar">

    <button type="button"
            class="gob-sidebar-toggle"
            aria-expanded="false"
            aria-controls="gob-sidebar-navigation">
        <i class="las la-bars" aria-hidden="true"></i>
        <span>Men&uacute;</span>
    </button>

    <div id="gob-sidebar-navigation" class="gob-sidebar-navigation">

    @if(!auth()->check() || auth()->user()->role != 1)
        <ul class="gob-menu">
            <li class="gob-sidebar-home {{ request()->routeIs('frontend.home') ? 'active' : '' }}">
                <a href="{{ route('frontend.home') }}">Inicio</a>
            </li>
<li class="gob-sidebar-login">
                    <a href="{{ route('auth.login') }}"><span class="gob-sidebar-login__label">Iniciar sesi&oacute;n</span></a>
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


            @if(auth()->user()->role == 4)
                <li class="gob-sidebar-home {{ request()->routeIs('frontend.home') ? 'active' : '' }}">
                    <a href="{{ route('frontend.home') }}">
                        Revisi&oacute;n final
                    </a>
                </li>
            @endif

            @if(auth()->user()->role != 1 && auth()->user()->role != 2)
                <li class="{{ request()->routeIs('messages.index', 'submissions.chat.*') ? 'active' : '' }}">
                    <a href="{{ route('messages.index') }}">
                        Mensajes
                        @if(request()->routeIs('messages.index') && isset($submissions))
                            <span class="secretary-menu-badge">{{ $submissions->count() }}</span>
                        @endif
                    </a>
                </li>
            @endif
            </ul>
        @endif

    @endauth

    </div>

</div>

@once
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            document.querySelectorAll('.gob-sidebar-toggle').forEach(function (toggle) {
                toggle.addEventListener('click', function () {
                    var sidebar = toggle.closest('.gob-sidebar');
                    var isOpen = sidebar.classList.toggle('is-mobile-open');
                    toggle.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
                });
            });
        });
    </script>
@endonce
