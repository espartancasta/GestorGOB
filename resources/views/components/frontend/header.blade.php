@php
    use Illuminate\Support\Facades\Auth;
    $userAvatar = (Auth::check() && !empty(Auth::user()->avatar))
        ? asset(Auth::user()->avatar)
        : asset('assets/frontend/img/default-avatar.svg');
@endphp

<header class="header fixed-top" style="background-color: var(--gob-primary-dark) !important; min-height: 80px; display: flex; align-items: center; width: 100%;">
    <div class="container">
        <div class="d-flex align-items-center justify-content-between w-100">

            {{-- 🔥 LOGO (YA NO VA A GOB.MX) --}}
            <div class="logo d-flex align-items-center">
                <a href="{{ route('frontend.home') }}">
                    <img src="https://framework-gb.cdn.gob.mx/gobmx/img/logo_blanco.svg"
                         alt="logo gobierno de méxico"
                         style="height:48px;">
                </a>
            </div>

            {{-- 🔥 DERECHA --}}
            <div class="header-right d-flex align-items-center" style="gap:20px;">

                {{-- ❌ QUITADO: TRÁMITES --}}
                {{-- SOLO DEJAMOS GOBIERNO --}}
                <div class="gob-header-links d-flex" style="gap:20px;">
                    <a href="https://www.gob.mx/gobierno" target="_blank"
                       style="color:#fff; text-decoration:none;">
                        Gobierno
                    </a>
                </div>

                {{-- 🔍 BUSCADOR --}}
                <div class="search-icon gob-circle-btn">
                    <i class="las la-search"></i>
                </div>

                @auth

                {{-- 🔔 NOTIFICACIONES --}}
                <div class="dropdown">
                    <button class="gob-circle-btn" data-toggle="dropdown">
                        <i class="las la-bell"></i>
                        <span class="gob-badge">1</span>
                    </button>
                </div>

                {{-- 👤 PERFIL --}}
                <div class="dropdown">
                    <button class="gob-circle-btn" data-toggle="dropdown">
                        <i class="las la-user-circle" style="font-size:30px;"></i>
                    </button>

                    <div class="dropdown-menu dropdown-menu-right gob-dropdown">

                        <a class="gob-profile-card" href="{{ route('frontend.user', Auth::user()->username) }}">
                            <img src="{{ $userAvatar }}" class="gob-profile-avatar">
                            <div>
                                <div class="fw-bold">{{ Auth::user()->name }}</div>
                                <small>Ir a tu perfil</small>
                            </div>
                        </a>

                        <div class="dropdown-divider"></div>

                        <form method="POST" action="{{ route('auth.logout') }}">
                            @csrf
                            <button type="submit" class="dropdown-item">
                                Cerrar sesión
                            </button>
                        </form>

                    </div>
                </div>

                @else

                <a href="{{ route('auth.login') }}" class="btn btn-light">
                    Iniciar sesión
                </a>

                @endauth

            </div>

        </div>
    </div>
</header>

<style>
.gob-circle-btn{
    width:40px;height:40px;
    border-radius:50%;
    display:flex;align-items:center;justify-content:center;
    color:#fff; cursor:pointer;
}

.gob-badge{
    position:absolute;
    top:-5px; right:-5px;
    background:red; color:#fff;
    font-size:10px; padding:2px 6px;
    border-radius:50%;
}

.gob-dropdown{
    min-width:250px;
    border-radius:12px;
    padding:10px;
}

.gob-profile-card{
    display:flex;
    gap:10px;
    align-items:center;
    text-decoration:none;
    color:inherit;
}

.gob-profile-avatar{
    width:40px;height:40px;border-radius:50%;
}
</style>