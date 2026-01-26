@php
    /* AVATAR GLOBAL */
    $userAvatar = (Auth::check() && !empty(Auth::user()->avatar))
        ? asset(Auth::user()->avatar)
        : asset('assets/frontend/img/default-avatar.svg');
@endphp

<header class="header navbar-expand-lg fixed-top">
    <div class="container-fluid">
        <div class="header-area">

            {{-- LOGO --}}
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

            {{-- NAVBAR (MENÚ DINÁMICO) --}}
            <div class="header-navbar">
                <nav class="navbar">
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#main_nav"
                        aria-expanded="false" aria-label="Mostrar navegación">
                        <span class="navbar-toggler-icon"></span>
                    </button>

                    <div class="collapse navbar-collapse" id="main_nav">
                        @if (isset($menu) && count($menu) > 0)
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

            {{-- DERECHA --}}
            <div class="header-right">

                {{-- BUSCAR --}}
                <div class="search-icon">
                    <i class="las la-search"></i>
                </div>

                @auth

                    {{-- NOTIFICACIONES --}}
                    <div class="dropdown">
                        <button class="gob-circle-btn" data-toggle="dropdown">
                            <i class="las la-bell"></i>
                            <span class="gob-badge">1</span>
                        </button>

                        <div class="dropdown-menu dropdown-menu-right gob-dropdown">
                            <div class="gob-title">Notificaciones</div>
                            <p class="gob-muted">Aún no conectadas</p>
                        </div>
                    </div>

                    {{-- PERFIL --}}
                    <div class="dropdown">
                        <button class="gob-circle-btn" data-toggle="dropdown" style="padding:0;">
                            <img src="{{ $userAvatar }}" alt="Avatar">
                        </button>

                        <div class="dropdown-menu dropdown-menu-right gob-dropdown">

                            {{-- TARJETA PERFIL --}}
                            <a href="{{ route('frontend.user', Auth::user()->username) }}" class="gob-profile-card">
                                <img src="{{ $userAvatar }}" class="gob-profile-avatar" alt="Avatar">
                                <div>
                                    <div class="gob-profile-name">{{ Auth::user()->name }}</div>
                                    <div class="gob-profile-sub">Ir a tu perfil</div>
                                </div>
                            </a>

                            <hr>

                            {{-- ESTADO --}}
                            <div class="dropdown dropleft">
                                <button class="dropdown-item gob-item-flex" id="statusMenu" data-toggle="dropdown">
                                    <span class="gob-item-left">
                                        <span id="statusDot" class="gob-dot green"></span>
                                        <span id="statusLabel">Disponible</span>
                                    </span>
                                    <i class="las la-angle-right"></i>
                                </button>

                                <div class="dropdown-menu gob-submenu">
                                    <button class="dropdown-item" onclick="setUserStatus('Disponible','green')">🟢 Disponible</button>
                                    <button class="dropdown-item" onclick="setUserStatus('Ocupado','red')">🔴 Ocupado</button>
                                    <button class="dropdown-item" onclick="setUserStatus('No molestar','gray')">⚫ No molestar</button>
                                    <button class="dropdown-item" onclick="setUserStatus('Vuelvo','yellow')">🟡 Vuelvo</button>
                                </div>
                            </div>

                            {{-- AYUDA --}}
                            <a class="dropdown-item gob-item-flex" href="#">
                                <i class="las la-question-circle"></i> Ayuda o asistencia
                            </a>

                            <hr>

                            {{-- LOGOUT --}}
                            <form method="POST" action="{{ route('auth.logout') }}">
                                @csrf
                                <button type="submit" class="dropdown-item gob-item-flex">
                                    <i class="las la-sign-out-alt"></i> Cerrar sesión
                                </button>
                            </form>

                        </div>
                    </div>

                    {{-- BOTÓN PANEL DE CONTROL (DEL REMOTO) --}}
                    <div class="botton-sub">
                        <a href="{{ route('dashboard.home') }}" class="btn-subscribe">Panel de Control</a>
                    </div>

                @else
                    <div class="botton-sub">
                        <a href="{{ route('auth.login') }}" class="btn-subscribe">Iniciar Sesión</a>
                    </div>
                @endauth

            </div>

        </div>
    </div>
</header>

{{-- ================= CSS ================= --}}
<style>
.header-area{
    display:flex;
    justify-content:space-between;
    align-items:center;
    gap:12px;
}

.header-right{
    display:flex;
    gap:12px;
    margin-left:auto;
    align-items:center;
}

.gob-circle-btn{
    width:42px;
    height:42px;
    border-radius:50%;
    border:1px solid #ddd;
    background:#fff;
    display:flex;
    align-items:center;
    justify-content:center;
    position:relative;
    cursor:pointer;
}

.gob-circle-btn img{
    width:100%;
    height:100%;
    border-radius:50%;
    object-fit:cover;
}

.gob-badge{
    position:absolute;
    top:-5px;
    right:-5px;
    background:red;
    color:white;
    font-size:11px;
    padding:2px 6px;
    border-radius:50%;
}

.gob-dropdown{
    min-width:320px;
    padding:15px;
    border-radius:15px;
    box-shadow:0 10px 25px rgba(0,0,0,.15);
}

.gob-profile-card{
    display:flex;
    gap:10px;
    align-items:center;
    text-decoration:none;
    color:black;
    border:1px solid #eee;
    padding:10px;
    border-radius:12px;
}

.gob-profile-avatar{
    width:50px;
    height:50px;
    border-radius:50%;
    object-fit:cover;
}

.gob-item-flex{
    display:flex;
    justify-content:space-between;
    align-items:center;
    padding:10px;
    border-radius:8px;
}

.gob-item-flex:hover{
    background:#f3f3f3;
}

.gob-dot.green{background:#28a745}
.gob-dot.red{background:#dc3545}
.gob-dot.gray{background:#6c757d}
.gob-dot.yellow{background:#ffc107}

.gob-dot{
    width:10px;
    height:10px;
    border-radius:50%;
    display:inline-block;
    margin-right:5px;
}
</style>

{{-- ================= SCRIPT ================= --}}
<script>
function setUserStatus(label,color){
    document.getElementById('statusLabel').innerText = label;
    document.getElementById('statusDot').className = 'gob-dot ' + color;
}
</script>
