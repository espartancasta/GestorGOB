@php
    use Illuminate\Support\Facades\Auth;
    use App\Models\Submission;
    use App\Models\SubmissionReviewer;

    $userAvatar = (Auth::check() && !empty(Auth::user()->avatar))
        ? asset(Auth::user()->avatar)
        : asset('assets/frontend/img/default-avatar.svg');

    /*
    |--------------------------------------------------------------------------
    | NOTIFICACIONES POR ROL
    |--------------------------------------------------------------------------
    | role 1 = Autor
    | role 2 = Revisor
    | role 3 = Secretario
    | role 4 = DICOVI
    */

    $notificationCount = 0;
    $notificationTitle = 'Sin notificaciones';
    $notificationText = 'No tienes pendientes por ahora.';
    $notificationUrl = '#';

    if (Auth::check()) {

        /*
        |--------------------------------------------------------------------------
        | AUTOR
        |--------------------------------------------------------------------------
        | Por ahora se cuentan documentos que regresaron a correcciÃƒÆ’Ã†â€™Ãƒâ€ Ã¢â‚¬â„¢ÃƒÆ’Ã¢â‚¬Å¡Ãƒâ€šÃ‚Â³n.
        | Cuando tengas pantalla de correcciones, aquÃƒÆ’Ã†â€™Ãƒâ€ Ã¢â‚¬â„¢ÃƒÆ’Ã¢â‚¬Å¡Ãƒâ€šÃ‚Â­ se cambia la URL.
        */
        if (Auth::user()->role == 1) {
            $notificationCount = Submission::where('author_id', Auth::id())
                ->where('status', 'pending_correction')
                ->count();

            $notificationTitle = 'Correcciones pendientes';
            $notificationText = 'Tienes documentos que requieren correcciÃƒÆ’Ã†â€™Ãƒâ€ Ã¢â‚¬â„¢ÃƒÆ’Ã¢â‚¬Å¡Ãƒâ€šÃ‚Â³n.';
            $notificationUrl = route('frontend.home');
        }

        /*
        |--------------------------------------------------------------------------
        | REVISOR
        |--------------------------------------------------------------------------
        | Cuenta invitaciones pendientes.
        */
        if (Auth::user()->role == 2) {
            $notificationCount = SubmissionReviewer::where('reviewer_id', Auth::id())
                ->where('status', 'invited')
                ->count();

            $notificationTitle = 'Invitaciones pendientes';
            $notificationText = 'Tienes solicitudes de revisiÃƒÆ’Ã†â€™Ãƒâ€ Ã¢â‚¬â„¢ÃƒÆ’Ã¢â‚¬Å¡Ãƒâ€šÃ‚Â³n por atender.';
            $notificationUrl = url('/review-invite/my');
        }

        /*
        |--------------------------------------------------------------------------
        | SECRETARIO
        |--------------------------------------------------------------------------
        | Cuenta documentos pendientes de asignaciÃƒÆ’Ã†â€™Ãƒâ€ Ã¢â‚¬â„¢ÃƒÆ’Ã¢â‚¬Å¡Ãƒâ€šÃ‚Â³n.
        */
        if (Auth::user()->role == 3) {
            $notificationCount = Submission::where('status', 'pending_assignment')
                ->count();

            $notificationTitle = 'Documentos pendientes';
            $notificationText = 'Hay documentos esperando asignaciÃƒÆ’Ã†â€™Ãƒâ€ Ã¢â‚¬â„¢ÃƒÆ’Ã¢â‚¬Å¡Ãƒâ€šÃ‚Â³n de revisores.';
            $notificationUrl = route('submissions.index');
        }

        /*
        |--------------------------------------------------------------------------
        | DICOVI
        |--------------------------------------------------------------------------
        | Por ahora no tiene flujo activo en pantalla.
        */
        if (Auth::user()->role == 4) {
            $notificationCount = Submission::where('status', 'completed')
                ->count();

            $notificationTitle = 'Procesos completados';
            $notificationText = 'Hay documentos completados en el sistema.';
            $notificationUrl = route('frontend.home');
        }
    }

    $authUser = Auth::user();
    $authorName = $authUser->name ?? 'Usuario';
    $authorInitials = collect(explode(' ', trim($authorName)))
        ->filter()
        ->take(2)
        ->map(fn ($part) => substr($part, 0, 1))
        ->implode('');
    $authorInitials = $authorInitials !== '' ? strtoupper($authorInitials) : 'AM';
@endphp

@if(Auth::check() && Auth::user()->role == 1)
<header class="author-topbar fixed-top">
    <a href="{{ route('frontend.home') }}" class="author-brand author-brand-logo" aria-label="Gobierno de Mexico">
        <img src="https://framework-gb.cdn.gob.mx/gobmx/img/logo_blanco.svg"
             alt="Logo Gobierno de M&eacute;xico">
    </a>

    <div class="author-topbar-actions">
        <div class="dropdown">
            <button type="button"
                    class="author-topbar-btn author-search-btn"
                    data-toggle="dropdown"
                    aria-haspopup="true"
                    aria-expanded="false">
                <i class="las la-search" aria-hidden="true"></i>
                <span>Buscar</span>
            </button>

            <div class="dropdown-menu dropdown-menu-right gob-search-dropdown">
                <form method="GET" action="{{ route('frontend.search') }}" style="margin:0;">
                    <label class="gob-search-label">Buscar documentos</label>
                    <div class="gob-search-box">
                        <input type="text"
                               name="q"
                               class="gob-search-input"
                               placeholder="T&iacute;tulo, autor o palabra clave..."
                               autocomplete="off">
                        <button type="submit" class="gob-search-submit">Buscar</button>
                    </div>
                    <small class="gob-search-help">Puedes buscar publicaciones o documentos registrados en el sistema.</small>
                </form>
            </div>
        </div>

        <div class="dropdown">
            <button type="button"
                    class="author-topbar-btn author-icon-btn"
                    data-toggle="dropdown"
                    aria-haspopup="true"
                    aria-expanded="false">
                <i class="las la-bell" aria-hidden="true"></i>
                <span class="author-notification-dot">{{ $notificationCount > 0 ? $notificationCount : '' }}</span>
            </button>

            <div class="dropdown-menu dropdown-menu-right gob-dropdown">
                <div class="gob-dropdown-title">Notificaciones</div>
                <div class="dropdown-divider"></div>

                @if($notificationCount > 0)
                    <a href="{{ $notificationUrl }}" class="gob-notification-item">
                        <div class="gob-notification-title">{{ $notificationTitle }}</div>
                        <small class="gob-notification-text">{{ $notificationText }}</small>
                    </a>
                @else
                    <div class="gob-empty-notification">No tienes notificaciones pendientes.</div>
                @endif
            </div>
        </div>

        <div class="dropdown">
            <button type="button"
                    class="author-user-chip"
                    data-toggle="dropdown"
                    aria-haspopup="true"
                    aria-expanded="false">
                <span class="author-user-initials">{{ $authorInitials }}</span>
                <span class="author-user-name">{{ $authorName }}</span>
                <span class="author-role-badge">Autor</span>
            </button>

            <div class="dropdown-menu dropdown-menu-right gob-dropdown">
                <a class="gob-profile-card" href="{{ route('profile.show') }}">
                    <span class="author-user-initials">{{ $authorInitials }}</span>
                    <div>
                        <div class="fw-bold">{{ $authorName }}</div>
                        <small>Ir a tu perfil</small>
                    </div>
                </a>

                <div class="dropdown-divider"></div>

                <form method="POST" action="{{ route('auth.logout') }}" style="margin:0;">
                    @csrf
                    <button type="submit" class="dropdown-item gob-logout-btn">Cerrar sesi&oacute;n</button>
                </form>
            </div>
        </div>
    </div>
</header>
@else
<header class="header fixed-top gob-institutional-header">

    <div class="gob-header__inner container">
        <div class="d-flex align-items-center justify-content-between w-100">

            {{-- LOGO --}}
            <div class="logo d-flex align-items-center">
                <a href="{{ route('frontend.home') }}">
                    <img src="https://framework-gb.cdn.gob.mx/gobmx/img/logo_blanco.svg" alt="Logo Gobierno de M&eacute;xico">
                </a>
            </div>

            {{-- DERECHA --}}
            <div class="header-right d-flex align-items-center gob-header__actions">

                {{-- LINK GOBIERNO --}}
                <div class="gob-header-links gob-header__utility" aria-label="Enlaces institucionales">
    <a href="https://www.gob.mx/tramites" target="_blank" rel="noopener noreferrer">Tr&aacute;mites</a>
    <a href="https://www.gob.mx/gobierno" target="_blank" rel="noopener noreferrer">Gobierno</a>
    <a href="https://www.gob.mx/en" target="_blank" rel="noopener noreferrer">English</a>
</div>

                {{-- BUSCADOR FUNCIONAL --}}
                <div class="dropdown">

                    <button type="button"
                            class="gob-circle-btn"
                            data-toggle="dropdown"
                            aria-haspopup="true"
                            aria-expanded="false">
                        <i class="las la-search"></i>
                    </button>

                    <div class="dropdown-menu dropdown-menu-right gob-search-dropdown">

                        <form method="GET"
                              action="{{ route('frontend.search') }}"
                              style="margin:0;">

                            <label class="gob-search-label">
                                Buscar documentos
                            </label>

                            <div class="gob-search-box">
                                <input type="text"
                                       name="q"
                                       class="gob-search-input"
                                       placeholder="T&iacute;tulo, autor o palabra clave..."
                                       autocomplete="off">

                                <button type="submit"
                                        class="gob-search-submit">
                                    Buscar
                                </button>
                            </div>

                            <small class="gob-search-help">
                                Puedes buscar publicaciones o documentos registrados en el sistema.
                            </small>

                        </form>

                    </div>

                </div>

                @auth

                    {{-- NOTIFICACIONES POR ROL --}}
                    <div class="dropdown">

                        <button type="button"
                                class="gob-circle-btn"
                                data-toggle="dropdown"
                                aria-haspopup="true"
                                aria-expanded="false">

                            <i class="las la-bell"></i>

                            @if($notificationCount > 0)
                                <span class="gob-badge">
                                    {{ $notificationCount }}
                                </span>
                            @endif

                        </button>

                        <div class="dropdown-menu dropdown-menu-right gob-dropdown">

                            <div class="gob-dropdown-title">
                                Notificaciones
                            </div>

                            <div class="dropdown-divider"></div>

                            @if($notificationCount > 0)

                                <a href="{{ $notificationUrl }}"
                                   class="gob-notification-item">

                                    <div class="gob-notification-title">
                                        {{ $notificationTitle }}
                                    </div>

                                    <small class="gob-notification-text">
                                        {{ $notificationText }}
                                    </small>

                                </a>

                            @else

                                <div class="gob-empty-notification">
                                    No tienes notificaciones pendientes.
                                </div>

                            @endif

                        </div>

                    </div>

                    {{-- PERFIL --}}
                    <div class="dropdown">

                        <button type="button"
                                class="gob-circle-btn"
                                data-toggle="dropdown"
                                aria-haspopup="true"
                                aria-expanded="false">
                            <i class="las la-user-circle gob-user-icon"></i>
                        </button>

                        <div class="dropdown-menu dropdown-menu-right gob-dropdown">

                            <a class="gob-profile-card"
                               href="{{ route('profile.show') }}">

                                <img src="{{ $userAvatar }}"
                                     class="gob-profile-avatar"
                                     alt="Avatar de usuario">

                                <div>
                                    <div class="fw-bold">
                                        {{ Auth::user()->name }}
                                    </div>

                                    <small>
                                        Ir a tu perfil
                                    </small>
                                </div>

                            </a>

                            <div class="dropdown-divider"></div>

                            {{-- Cierre de sesiÃƒÂ³n: POST + CSRF --}}
                            <form method="POST"
                                  action="{{ route('auth.logout') }}"
                                  style="margin:0;">
                                @csrf

                                <button type="submit"
                                        class="dropdown-item gob-logout-btn">
                                    Cerrar sesi&oacute;n
                                </button>
                            </form>

                        </div>

                    </div>
                @else
                @endauth

            </div>

        </div>
    </div>

</header>
@endif

<nav class="gob-inifap-nav" aria-label="NavegaciÃƒÆ’Ã†â€™Ãƒâ€šÃ‚Â³n principal INIFAP">
    <div class="gob-inifap-nav__inner">
        <a class="gob-inifap-nav__brand" href="{{ route('frontend.home') }}">Inifap</a>
        <ul class="gob-inifap-nav__menu">
            <li><a href="https://www.gob.mx/inifap#blog" target="_blank" rel="noopener noreferrer">Blog</a></li>
            <li><a href="https://www.gob.mx/inifap#galeria" target="_blank" rel="noopener noreferrer">&Aacute;lbum de fotos</a></li>
            <li><a href="https://www.gob.mx/inifap#prensa" target="_blank" rel="noopener noreferrer">Prensa</a></li>
            <li><a href="https://www.gob.mx/inifap#agenda" target="_blank" rel="noopener noreferrer">Agenda</a></li>
            <li><a href="https://www.gob.mx/inifap#acciones" target="_blank" rel="noopener noreferrer">Acciones y Programas</a></li>
            <li><a href="https://www.gob.mx/inifap#documentos" target="_blank" rel="noopener noreferrer">Documentos</a></li>
            <li><a href="https://www.gob.mx/inifap#transparencia" target="_blank" rel="noopener noreferrer">Transparencia</a></li>
            <li><a href="https://www.gob.mx/inifap#contacto" target="_blank" rel="noopener noreferrer">Contacto</a></li>
        </ul>
    </div>
</nav><style>
/* =========================================================
   HEADER GOB
========================================================= */

.gob-circle-btn {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    border: none;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #fff;
    cursor: pointer;
    background: transparent;
    position: relative;
    padding: 0;
}

.gob-circle-btn:hover {
    background: rgba(255,255,255,0.12);
}

.gob-circle-btn i {
    font-size: 22px;
}

/* BADGE DE NOTIFICACIÃƒÆ’Ã†â€™Ãƒâ€ Ã¢â‚¬â„¢ÃƒÆ’Ã‚Â¢ÃƒÂ¢Ã¢â‚¬Å¡Ã‚Â¬Ãƒâ€¦Ã¢â‚¬Å“N */
.gob-badge {
    position: absolute;
    top: -5px;
    right: -5px;
    background: #e60023;
    color: #fff;
    font-size: 10px;
    font-weight: 700;
    min-width: 18px;
    height: 18px;
    padding: 2px 5px;
    border-radius: 999px;
    display: flex;
    align-items: center;
    justify-content: center;
}

/* DROPDOWN GENERAL */
.gob-dropdown {
    min-width: 270px;
    border-radius: 12px;
    padding: 10px;
    border: 1px solid #e5e5e5;
    box-shadow: 0 12px 28px rgba(0,0,0,0.12);
}

.gob-dropdown-title {
    padding: 8px 10px;
    font-weight: 700;
    color: #545454;
}

/* PERFIL */
.gob-profile-card {
    display: flex;
    gap: 10px;
    align-items: center;
    text-decoration: none !important;
    color: inherit !important;
    padding: 8px;
    border-radius: 8px;
}

.gob-profile-card:hover {
    background: #f5f5f5;
}

.gob-profile-avatar {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    object-fit: cover;
}

/* LOGOUT */
.gob-logout-btn {
    width: 100%;
    text-align: left;
    background: transparent;
    border: 0;
    font-weight: 700;
    color: #545454;
    padding: 8px 12px;
    cursor: pointer;
}

.gob-logout-btn:hover {
    background: #f5f5f5;
    color: #611232;
}

/* NOTIFICACIONES */
.gob-notification-item {
    display: block;
    padding: 10px 12px;
    border-radius: 8px;
    text-decoration: none !important;
    white-space: normal;
}

.gob-notification-item:hover {
    background: #f6eef1;
}

.gob-notification-title {
    font-weight: 700;
    color: #611232;
    margin-bottom: 3px;
}

.gob-notification-text {
    color: #777;
    font-size: 13px;
}

.gob-empty-notification {
    padding: 10px 12px;
    color: #777;
    font-size: 14px;
}

/* BUSCADOR */
.gob-search-dropdown {
    min-width: 380px;
    border-radius: 12px;
    padding: 16px;
    border: 1px solid #e5e5e5;
    box-shadow: 0 12px 28px rgba(0,0,0,0.12);
}

.gob-search-label {
    font-weight: 700;
    color: #545454;
    margin-bottom: 8px;
    display: block;
}

.gob-search-box {
    display: flex;
    gap: 8px;
}

.gob-search-input {
    flex: 1;
    min-height: 42px;
    border: 1px solid #ddd;
    border-radius: 8px;
    padding: 0 12px;
    color: #545454;
    outline: none;
}

.gob-search-input:focus {
    border-color: #611232;
    box-shadow: 0 0 0 0.15rem rgba(97,18,50,0.12);
}

.gob-search-submit {
    min-height: 42px;
    border: none;
    border-radius: 8px;
    background: #611232;
    color: #fff;
    font-weight: 700;
    padding: 0 16px;
    cursor: pointer;
}

.gob-search-submit:hover {
    background: #4a0e26;
}

.gob-search-help {
    display: block;
    margin-top: 8px;
    color: #777;
    font-size: 12px;
}

/* RESPONSIVE */
@media (max-width: 768px) {
    .gob-header-links {
        display: none !important;
    }

    .gob-search-dropdown {
        min-width: 300px;
    }

    .header-right {
        gap: 10px !important;
    }
}
</style>
