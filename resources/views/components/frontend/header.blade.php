@php
    use Illuminate\Support\Facades\Auth;
    $userAvatar = (Auth::check() && !empty(Auth::user()->avatar))
        ? asset(Auth::user()->avatar)
        : asset('assets/frontend/img/default-avatar.svg');
@endphp

<header class="header fixed-top" style="background-color: var(--gob-primary-dark) !important; box-shadow: none !important; border-bottom: none !important; min-height: 80px; display: flex; align-items: center; width: 100%;">
    <div class="container">
        <div class="d-flex align-items-center justify-content-between w-100" style="padding:0; min-height: 80px;">

            {{-- LOGO OFICIAL --}}
            <div class="logo m-0 p-0" style="display:flex; align-items:center;">
                <a href="https://www.gob.mx/" target="_blank">
                    <img src="https://framework-gb.cdn.gob.mx/gobmx/img/logo_blanco.svg" alt="logo gobierno de méxico" style="height:48px; width:auto; max-width:none;"/>
                </a>
            </div>

            {{-- DERECHA --}}
            <div class="header-right ms-auto d-flex align-items-center justify-content-end" style="gap:24px; padding-right:0; margin-left:auto;">

                {{-- LINKS OFICIALES --}}
                <div class="gob-header-links" style="display:flex; gap:24px; font-size:16px; font-weight:300;">
                    <a href="https://www.gob.mx/tramites" target="_blank" style="color:#fff; text-decoration:none;">Trámites</a>
                    <a href="https://www.gob.mx/gobierno" target="_blank" style="color:#fff; text-decoration:none;">Gobierno</a>
                </div>

                {{-- BUSCADOR --}}
                <div class="search-icon gob-circle-btn" style="cursor:pointer; width:auto; height:auto;">
                    <i class="las la-search" style="font-size:20px;"></i>
                </div>

                @auth
                    {{-- NOTIFICACIONES --}}
                    <div class="dropdown">
                        <button type="button" class="gob-circle-btn" id="notifMenu"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
                                title="Notificaciones">
                            <i class="las la-bell"></i>
                            <span class="gob-badge">1</span>
                        </button>

                        <div class="dropdown-menu dropdown-menu-right gob-dropdown" aria-labelledby="notifMenu">
                            <div class="gob-dropdown-title">Notificaciones</div>
                            <div class="gob-dropdown-muted">Aún no conectadas.</div>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="javascript:void(0)">Ver todas (pendiente)</a>
                        </div>
                    </div>

                    {{-- PERFIL --}}
                    <div class="dropdown">
                        <button type="button" class="gob-circle-btn" id="userMenu"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
                                title="Tu cuenta" style="padding:0; overflow:hidden; border:none; background:transparent;">
                            <i class="las la-user-circle" style="font-size:32px; color:#fff;"></i>
                        </button>

                        <div class="dropdown-menu dropdown-menu-right gob-dropdown" aria-labelledby="userMenu">

                            {{-- 1) Foto + nombre -> perfil --}}
                            <a class="gob-profile-card" href="{{ route('frontend.user', Auth::user()->username) }}">
                                <img src="{{ $userAvatar }}" alt="avatar" class="gob-profile-avatar">
                                <div class="gob-profile-text">
                                    <div class="gob-profile-name">{{ Auth::user()->name ?? 'Usuario' }}</div>
                                    <div class="gob-profile-sub">Ir a tu perfil</div>
                                </div>
                            </a>

                            <div class="dropdown-divider"></div>

                            {{-- 2) Estado (submenú) --}}
                            <div class="dropdown dropleft">
                                <button type="button" class="dropdown-item gob-item-flex"
                                        id="statusMenu" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <span class="gob-item-left">
                                        <span id="statusDot" class="gob-dot" style="background:#28a745;"></span>
                                        <span id="statusLabel" class="gob-item-text">Disponible</span>
                                    </span>
                                    <i class="las la-angle-right"></i>
                                </button>

                                <div class="dropdown-menu gob-submenu" aria-labelledby="statusMenu">
                                    <button class="dropdown-item" type="button" onclick="setUserStatus('Disponible', '#28a745')">
                                        <span class="gob-dot" style="background:#28a745;"></span> Disponible
                                    </button>
                                    <button class="dropdown-item" type="button" onclick="setUserStatus('Ocupado', '#dc3545')">
                                        <span class="gob-dot" style="background:#dc3545;"></span> Ocupado
                                    </button>
                                    <button class="dropdown-item" type="button" onclick="setUserStatus('No molestar', '#6c757d')">
                                        <span class="gob-dot" style="background:#6c757d;"></span> No molestar
                                    </button>
                                    <button class="dropdown-item" type="button" onclick="setUserStatus('Vuelvo enseguida', '#ffc107')">
                                        <span class="gob-dot" style="background:#ffc107;"></span> Vuelvo enseguida
                                    </button>
                                    <button class="dropdown-item" type="button" onclick="setUserStatus('Desconectado', '#343a40')">
                                        <span class="gob-dot" style="background:#343a40;"></span> Desconectado
                                    </button>
                                </div>
                            </div>

                            {{-- 3) Ayuda --}}
                            <a class="dropdown-item gob-item-flex" href="javascript:void(0)">
                                <span class="gob-item-left">
                                    <i class="las la-question-circle gob-ico"></i>
                                    <span class="gob-item-text">Ayuda o asistencia</span>
                                </span>
                            </a>

                            <div class="dropdown-divider"></div>

                            {{-- 4) Logout --}}
                            <form method="POST" action="{{ route('auth.logout') }}" style="margin:0;">
                                @csrf
                                <button type="submit" class="dropdown-item gob-item-flex" style="width:100%;">
                                    <span class="gob-item-left">
                                        <i class="las la-sign-out-alt gob-ico"></i>
                                        <span class="gob-item-text">Cerrar sesión</span>
                                    </span>
                                </button>
                            </form>
                        </div>
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

<style>
    .gob-circle-btn{
        width:42px;height:42px;
        border-radius:50%;
        border:1px solid transparent;
        background:transparent;
        display:flex;align-items:center;justify-content:center;
        position:relative;
        cursor:pointer;
        color:#fff;
    }
    .gob-circle-btn i{ font-size:24px; color:#fff; }
    .gob-badge{
        position:absolute;
        top:-6px; right:-6px;
        background:#d00;
        color:#fff;
        border-radius:999px;
        font-size:11px;
        padding:2px 6px;
        line-height:1;
        border:2px solid #fff;
    }

    .gob-dropdown{
        min-width:340px;
        padding:12px;
        border-radius:14px;
        border:1px solid rgba(0,0,0,.08);
        box-shadow:0 12px 24px rgba(0,0,0,.10);
    }
    .gob-dropdown-title{ font-weight:800; margin-bottom:6px; }
    .gob-dropdown-muted{ font-size:13px; color:#666; }

    .gob-profile-card{
        display:flex;
        align-items:center;
        gap:10px;
        padding:10px;
        border:1px solid rgba(0,0,0,.08);
        border-radius:14px;
        text-decoration:none;
        color:inherit;
        transition:all .15s ease;
    }
    .gob-profile-card:hover{ background:rgba(0,0,0,.03); }
    .gob-profile-avatar{ width:48px;height:48px;border-radius:50%;object-fit:cover; }
    .gob-profile-name{ font-weight:800; }
    .gob-profile-sub{ font-size:12px; color:#666; }

    .gob-item-flex{
        display:flex;
        align-items:center;
        justify-content:space-between;
        border-radius:10px;
        padding:10px 12px;
    }
    .gob-item-left{
        display:flex;
        align-items:center;
        gap:10px;
    }
    .gob-ico{ font-size:20px; color:#5b5b5b; }
    .gob-item-text{ font-weight:600; }

    .gob-dot{ width:10px;height:10px;border-radius:50%; display:inline-block; }

    .gob-submenu{
        min-width:220px;
        border-radius:14px;
        border:1px solid rgba(0,0,0,.08);
        box-shadow:0 12px 24px rgba(0,0,0,.10);
    }
    .gob-submenu .dropdown-item{
        display:flex;
        align-items:center;
        gap:10px;
        padding:10px 12px;
    }

    /* Estilos estructurales movidos a estilos-gobmx.css */
</style>

<script>
    function setUserStatus(label, color) {
        var labelEl = document.getElementById('statusLabel');
        var dotEl = document.getElementById('statusDot');
        if (labelEl) labelEl.textContent = label;
        if (dotEl) dotEl.style.background = color;
    }
</script>
