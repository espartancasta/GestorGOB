@extends('frontend.master')

@section('title', 'Perfil de usuario')

@section('content')

@php
    $name = $user->name ?? 'Usuario';
    $initials = collect(explode(' ', trim($name)))
        ->filter()
        ->take(2)
        ->map(fn ($part) => substr($part, 0, 1))
        ->implode('');
    $initials = $initials !== '' ? strtoupper($initials) : 'US';
    $registeredAt = $user->created_at ? $user->created_at->format('d/m/Y') : 'No disponible';
    $lastAccess = $user->last_login_at ?? $user->last_access_at ?? null;
    $lastAccessLabel = $lastAccess ? \Carbon\Carbon::parse($lastAccess)->format('d/m/Y') : now()->format('d/m/Y');
    $institution = $user->company ?? $user->institution ?? $user->empresa ?? 'INIFAP';
    $department = $user->department ?? $user->departamento ?? 'Investigacion y Desarrollo';
    $gender = $user->sex ?? $user->sexo ?? 'No especificado';
    $age = $user->age ?? $user->edad ?? 'No especificada';
    $curp = $user->curp ?? 'No registrada';
    $rfc = $user->rfc ?? 'No registrado';
    $phone = $user->phone ?? $user->telefono ?? 'No registrado';
    $location = $user->location ?? $user->ubicacion ?? 'Mexico';
@endphp

<style>
.profile-page { min-height: calc(100vh - 72px); padding: 34px 0 50px; background: #f7f7f7; color: #111827; }
.profile-breadcrumb { display: flex; gap: 9px; margin-bottom: 20px; color: #7a5364; font-size: 13px; font-weight: 700; }
.profile-breadcrumb a { color: #7a5364 !important; text-decoration: none !important; }
.profile-heading { margin-bottom: 24px; }
.profile-heading h1 { margin: 0 0 6px; color: #111827 !important; font-size: 26px; font-weight: 900 !important; }
.profile-heading p { margin: 0; color: #7a5364 !important; font-size: 15px; }
.profile-card { border: 1px solid #e8cfd8; border-radius: 12px; background: #fff; box-shadow: 0 8px 18px rgba(97,18,50,.07); }
.profile-hero { display: flex; align-items: center; justify-content: space-between; gap: 24px; padding: 36px 30px; margin-bottom: 20px; }
.profile-identity { display: flex; align-items: center; gap: 24px; min-width: 0; }
.profile-avatar { position: relative; display: inline-flex; align-items: center; justify-content: center; width: 104px; height: 104px; border: 5px solid #e4cc4b; border-radius: 50%; background: #8a1538; color: #e4cc4b !important; font-size: 30px; font-weight: 900; box-shadow: 0 0 0 4px #f6eed1; }
.profile-avatar::after { content: ""; position: absolute; right: 3px; bottom: 8px; width: 14px; height: 14px; border: 2px solid #fff; border-radius: 50%; background: #22c55e; }
.profile-person h2 { display: flex; align-items: center; gap: 10px; margin: 0 0 12px; color: #111827 !important; font-size: 24px; font-weight: 900 !important; }
.profile-role { display: inline-flex; align-items: center; min-height: 24px; padding: 3px 10px; border-radius: 999px; background: #611232; color: #fff !important; font-size: 12px; font-weight: 900; }
.profile-meta { display: grid; gap: 7px; }
.profile-meta span { display: inline-flex; align-items: center; gap: 8px; color: #7a5364 !important; font-size: 14px; }
.profile-meta i { color: #8a1538 !important; font-size: 16px; }
.profile-meta .is-active, .profile-meta .is-active i { color: #16a34a !important; }
.profile-actions { display: grid; gap: 10px; min-width: 192px; }
.profile-btn { display: inline-flex; align-items: center; justify-content: center; gap: 8px; min-height: 40px; padding: 0 18px; border: 1px solid #e3bbc8; border-radius: 8px; font-weight: 900; text-decoration: none !important; }
.profile-btn-primary { border-color: #611232; background: #611232; color: #fff !important; box-shadow: 0 8px 14px rgba(97,18,50,.22); }
.profile-btn-secondary { background: #fff; color: #611232 !important; }
.profile-section-title { margin: 18px 0 14px; color: #611232 !important; font-size: 15px; font-weight: 900 !important; letter-spacing: .6px; text-transform: uppercase; }
.profile-stats { display: grid; grid-template-columns: repeat(4, minmax(140px, 1fr)); gap: 14px; margin-bottom: 20px; }
.profile-stat { display: flex; align-items: center; gap: 16px; min-height: 116px; padding: 20px; }
.profile-stat-icon, .profile-contact-icon { display: inline-flex; align-items: center; justify-content: center; flex: 0 0 auto; width: 44px; height: 44px; border-radius: 10px; font-size: 22px; }
.profile-stat strong { display: block; color: #111827; font-size: 26px; line-height: 1; }
.profile-stat span { display: block; margin-top: 5px; color: #7a5364 !important; font-size: 14px; line-height: 1.3; }
.tone-wine { background: #f2e9ee; color: #8a1538; }
.tone-orange { background: #fff0df; color: #f97316; }
.tone-green { background: #e9f8ef; color: #22c55e; }
.tone-gold { background: #fbf3df; color: #d4a617; }
.profile-two-col { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 40px; }
.profile-panel { padding: 26px 28px; }
.profile-panel h2 { margin: 0 0 16px; padding-bottom: 14px; border-bottom: 1px solid #ead7df; color: #611232 !important; font-size: 16px; font-weight: 900 !important; }
.profile-fields { display: grid; grid-template-columns: repeat(2, 1fr); gap: 18px 28px; }
.profile-field label { display: block; margin-bottom: 3px; color: #7a5364 !important; font-size: 11px; font-weight: 900; letter-spacing: 1px; text-transform: uppercase; }
.profile-field span { color: #111827 !important; font-size: 15px; font-weight: 600; line-height: 1.35; }
.profile-security .profile-fields { grid-template-columns: 1fr; gap: 15px; }
.profile-status-pill { display: inline-flex; align-items: center; gap: 7px; min-height: 24px; width: fit-content; padding: 3px 12px; border-radius: 999px; background: #d9f8e6; color: #087d3c !important; font-size: 13px; font-weight: 900; }
.profile-status-pill::before { content: ""; width: 7px; height: 7px; border-radius: 50%; background: #22c55e; }
.profile-security .profile-btn { margin-top: 16px; width: fit-content; }
.profile-contact { padding: 26px 28px 22px; }
.profile-contact h2 { margin: 0 0 20px; padding-bottom: 14px; border-bottom: 1px solid #ead7df; color: #611232 !important; font-size: 16px; font-weight: 900 !important; }
.profile-contact-grid { display: grid; grid-template-columns: repeat(2, 1fr); gap: 12px 36px; }
.profile-contact-item { display: flex; align-items: center; gap: 12px; }
.profile-contact-item label { display: block; color: #7a5364 !important; font-size: 11px; font-weight: 900; letter-spacing: 1px; text-transform: uppercase; }
.profile-contact-item span { color: #111827 !important; font-size: 15px; font-weight: 600; }
.profile-note { display: flex; gap: 10px; margin-top: 18px; padding: 12px 14px; border: 1px solid #ead69a; border-radius: 8px; background: #fffaf0; color: #8a6416 !important; font-size: 13px; }
.profile-alert { margin-bottom: 16px; padding: 12px 16px; border: 1px solid #bce5cb; border-radius: 8px; background: #e9f8ef; color: #087d3c !important; font-weight: 800; }
@media (max-width: 900px) {
    .profile-hero, .profile-identity { align-items: flex-start; flex-direction: column; }
    .profile-actions { width: 100%; }
    .profile-stats, .profile-two-col, .profile-contact-grid { grid-template-columns: 1fr; }
    .profile-fields { grid-template-columns: 1fr; }
}
</style>

<div class="gob-dashboard">
    @include('frontend.home.inc.sidebar')

    <div class="gob-main">
        <section class="profile-page" aria-labelledby="profile-title">
            <nav class="profile-breadcrumb" aria-label="Ruta de navegacion">
                <a href="{{ route('frontend.home') }}">Inicio</a>
                <span>&gt;</span>
                <span>Perfil de usuario</span>
            </nav>

            <header class="profile-heading">
                <h1 id="profile-title">Perfil de usuario</h1>
                <p>Consulta y administra la informacion general asociada a tu cuenta de Autor.</p>
            </header>

            @if(session('success'))
                <div class="profile-alert">{{ session('success') }}</div>
            @endif

            <article class="profile-card profile-hero">
                <div class="profile-identity">
                    <span class="profile-avatar">{{ $initials }}</span>
                    <div class="profile-person">
                        <h2>{{ $name }} <span class="profile-role">Autor</span></h2>
                        <div class="profile-meta">
                            <span><i class="las la-envelope" aria-hidden="true"></i> {{ $user->email ?? 'Sin correo registrado' }}</span>
                            <span class="is-active"><i class="las la-shield-alt" aria-hidden="true"></i> Cuenta activa</span>
                            <span><i class="las la-clock" aria-hidden="true"></i> Registro: {{ $registeredAt }}</span>
                        </div>
                    </div>
                </div>

                <div class="profile-actions">
                    <a href="{{ route('profile.edit') }}" class="profile-btn profile-btn-primary">
                        <i class="las la-pen" aria-hidden="true"></i>
                        Editar perfil
                    </a>
                    <a href="{{ route('profile.edit') }}" class="profile-btn profile-btn-secondary">
                        <i class="las la-lock" aria-hidden="true"></i>
                        Cambiar contrase&ntilde;a
                    </a>
                </div>
            </article>

            <h2 class="profile-section-title">Actividad del autor</h2>
            <div class="profile-stats">
                <article class="profile-card profile-stat">
                    <span class="profile-stat-icon tone-wine"><i class="las la-file-alt" aria-hidden="true"></i></span>
                    <div><strong>{{ $stats['total_submissions'] }}</strong><span>Propuestas registradas</span></div>
                </article>
                <article class="profile-card profile-stat">
                    <span class="profile-stat-icon tone-orange"><i class="las la-clock" aria-hidden="true"></i></span>
                    <div><strong>{{ $stats['in_process'] }}</strong><span>En proceso de evaluacion</span></div>
                </article>
                <article class="profile-card profile-stat">
                    <span class="profile-stat-icon tone-green"><i class="las la-check-circle" aria-hidden="true"></i></span>
                    <div><strong>{{ $stats['completed'] }}</strong><span>Revision completada</span></div>
                </article>
                <article class="profile-card profile-stat">
                    <span class="profile-stat-icon tone-gold"><i class="las la-comment" aria-hidden="true"></i></span>
                    <div><strong>{{ $stats['active_chats'] }}</strong><span>Chats activos</span></div>
                </article>
            </div>

            <div class="profile-two-col">
                <article class="profile-card profile-panel">
                    <h2>Informacion general</h2>
                    <div class="profile-fields">
                        <div class="profile-field"><label>Perfil</label><span>Autor</span></div>
                        <div class="profile-field"><label>Empresa / Institucion</label><span>{{ $institution }}</span></div>
                        <div class="profile-field"><label>Departamento</label><span>{{ $department }}</span></div>
                        <div class="profile-field"><label>Sexo</label><span>{{ $gender }}</span></div>
                        <div class="profile-field"><label>Edad</label><span>{{ $age }}</span></div>
                        <div class="profile-field"><label>CURP</label><span>{{ $curp }}</span></div>
                        <div class="profile-field"><label>RFC</label><span>{{ $rfc }}</span></div>
                        <div class="profile-field"><label>Registro</label><span>{{ $registeredAt }}</span></div>
                    </div>
                </article>

                <article class="profile-card profile-panel profile-security">
                    <h2>Seguridad de la cuenta</h2>
                    <div class="profile-fields">
                        <div class="profile-field"><label>Contrase&ntilde;a</label><span>Actualizada recientemente</span></div>
                        <div class="profile-field"><label>Ultimo acceso</label><span>{{ $lastAccessLabel }}</span></div>
                        <div class="profile-field"><label>Estado</label><span class="profile-status-pill">Cuenta activa</span></div>
                    </div>
                    <a href="{{ route('profile.edit') }}" class="profile-btn profile-btn-secondary">
                        <i class="las la-shield-alt" aria-hidden="true"></i>
                        Actualizar seguridad
                    </a>
                </article>
            </div>

            <article class="profile-card profile-contact">
                <h2>Informacion de contacto</h2>
                <div class="profile-contact-grid">
                    <div class="profile-contact-item">
                        <span class="profile-contact-icon tone-wine"><i class="las la-envelope" aria-hidden="true"></i></span>
                        <div><label>Correo electronico</label><span>{{ $user->email ?? 'No registrado' }}</span></div>
                    </div>
                    <div class="profile-contact-item">
                        <span class="profile-contact-icon tone-wine"><i class="las la-phone" aria-hidden="true"></i></span>
                        <div><label>Telefono</label><span>{{ $phone }}</span></div>
                    </div>
                    <div class="profile-contact-item">
                        <span class="profile-contact-icon tone-wine"><i class="las la-university" aria-hidden="true"></i></span>
                        <div><label>Institucion</label><span>{{ $institution }}</span></div>
                    </div>
                    <div class="profile-contact-item">
                        <span class="profile-contact-icon tone-wine"><i class="las la-map-marker" aria-hidden="true"></i></span>
                        <div><label>Ubicacion</label><span>{{ $location }}</span></div>
                    </div>
                </div>

                <div class="profile-note">
                    <i class="las la-info" aria-hidden="true"></i>
                    La informacion de contacto permite dar seguimiento al proceso de revision documental.
                </div>
            </article>
        </section>
    </div>
</div>

@endsection
