@extends('frontend.master')

@section('title', 'Editar perfil')

@section('content')

@php
    $name = $user->name ?? 'Usuario';
    $initials = collect(explode(' ', trim($name)))
        ->filter()
        ->take(2)
        ->map(fn ($part) => substr($part, 0, 1))
        ->implode('');
    $initials = $initials !== '' ? strtoupper($initials) : 'US';
    $institution = old('institution', $user->institution ?? 'INIFAP');
@endphp

<style>
.edit-profile-page { min-height: calc(100vh - 72px); padding: 34px 0 50px; background: #f7f7f7; color: #111827; }
.edit-profile-breadcrumb { display: flex; gap: 8px; margin-bottom: 24px; color: #7a5364; font-size: 13px; font-weight: 700; }
.edit-profile-breadcrumb a { color: #7a5364 !important; text-decoration: none !important; }
.edit-profile-breadcrumb strong { color: #611232; }
.edit-profile-heading { margin-bottom: 26px; }
.edit-profile-heading h1 { margin: 0 0 6px; color: #111827 !important; font-size: 26px; font-weight: 900 !important; }
.edit-profile-heading p { margin: 0; color: #7a5364 !important; font-size: 15px; }
.edit-profile-layout { display: grid; grid-template-columns: minmax(0, 1fr) 240px; gap: 20px; align-items: start; }
.edit-profile-card { border: 1px solid #e8cfd8; border-radius: 12px; background: #fff; box-shadow: 0 8px 18px rgba(97,18,50,.07); overflow: hidden; }
.edit-form-head { display: flex; align-items: center; gap: 10px; min-height: 48px; padding: 0 26px; background: #611232; color: #fff; font-weight: 900; }
.edit-form-head::before { content: ""; width: 9px; height: 9px; border-radius: 50%; background: #d4af37; }
.edit-form-body { padding: 26px 30px 32px; }
.edit-photo-box { display: flex; align-items: center; gap: 20px; margin-bottom: 26px; padding: 18px; border: 1px solid #e8cfd8; border-radius: 10px; background: #fff9fb; }
.edit-avatar { display: inline-flex; align-items: center; justify-content: center; flex: 0 0 auto; width: 76px; height: 76px; border: 4px solid #d4af37; border-radius: 50%; background: #8a1538; color: #e4cc4b !important; font-size: 24px; font-weight: 900; box-shadow: 0 0 0 3px #f6eed1; }
.edit-photo-meta { display: grid; gap: 8px; }
.edit-photo-btn { display: inline-flex; align-items: center; justify-content: center; gap: 7px; width: fit-content; min-height: 34px; padding: 0 14px; border: 1px solid #e8cfd8; border-radius: 7px; background: #fff; color: #611232 !important; font-size: 13px; font-weight: 900; }
.edit-photo-meta span { color: #7a5364 !important; font-size: 12px; }
.edit-section { margin-top: 24px; }
.edit-section-title { display: flex; align-items: center; gap: 11px; margin-bottom: 16px; color: #611232; font-size: 14px; font-weight: 900; letter-spacing: .7px; text-transform: uppercase; }
.edit-section-title::before { content: ""; width: 4px; height: 18px; border-radius: 999px; background: #611232; }
.edit-section-title::after { content: ""; flex: 1; height: 1px; background: #ead7df; }
.edit-grid { display: grid; grid-template-columns: repeat(2, minmax(0, 1fr)); gap: 16px 24px; }
.edit-field { display: grid; gap: 7px; min-width: 0; }
.edit-field.is-wide { grid-column: 1 / -1; }
.edit-field label { margin: 0; color: #3d1427 !important; font-size: 11px; font-weight: 900; letter-spacing: .8px; text-transform: uppercase; }
.edit-field input, .edit-field textarea, .edit-field select { width: 100%; min-height: 42px !important; padding: 10px 14px !important; border: 1px solid #e7ccd6 !important; border-radius: 8px !important; background: #fffbfc !important; color: #111827 !important; font-size: 15px; outline: none; }
.edit-field textarea { min-height: 104px !important; resize: vertical; }
.edit-field input:focus, .edit-field textarea:focus, .edit-field select:focus { border-color: #611232 !important; box-shadow: 0 0 0 3px rgba(97,18,50,.08) !important; }
.edit-field input::placeholder, .edit-field textarea::placeholder { color: #9b8791 !important; }
.edit-error { color: #b42318 !important; font-size: 12px; font-weight: 700; }
.edit-form-actions { display: flex; align-items: center; flex-wrap: wrap; gap: 12px; margin-top: 34px; padding-top: 20px; border-top: 1px solid #ead7df; }
.edit-btn { display: inline-flex; align-items: center; justify-content: center; gap: 8px; min-height: 42px; padding: 0 22px; border-radius: 8px; font-size: 14px; font-weight: 900; text-decoration: none !important; cursor: pointer; }
.edit-btn-primary { border: 0; background: #611232; color: #fff !important; box-shadow: 0 8px 14px rgba(97,18,50,.24); }
.edit-btn-secondary { border: 1px solid #8a1538; background: #fff; color: #611232 !important; }
.edit-back-link { display: inline-flex; align-items: center; gap: 8px; margin-left: auto; color: #7a5364 !important; font-weight: 800; text-decoration: none !important; }
.edit-side { display: grid; gap: 16px; }
.edit-side-card { padding: 18px; border: 1px solid #e8cfd8; border-radius: 10px; background: #fff; box-shadow: 0 8px 18px rgba(97,18,50,.06); }
.edit-recommend h2 { display: flex; align-items: center; gap: 8px; margin: -18px -18px 14px; padding: 13px 16px; border-bottom: 1px solid #ead7df; color: #611232 !important; font-size: 13px; font-weight: 900 !important; letter-spacing: .8px; text-transform: uppercase; }
.edit-tips { display: grid; gap: 12px; margin: 0; padding: 0; list-style: none; }
.edit-tips li { display: flex; gap: 10px; color: #7a5364 !important; font-size: 13px; line-height: 1.45; }
.edit-tip-number { display: inline-flex; align-items: center; justify-content: center; flex: 0 0 auto; width: 20px; height: 20px; border: 1px solid #ead69a; border-radius: 50%; background: #fff9e8; color: #d4a617 !important; font-size: 11px; font-weight: 900; }
.edit-preview { text-align: center; }
.edit-preview .edit-avatar { width: 58px; height: 58px; margin-bottom: 12px; font-size: 18px; }
.edit-preview h2 { margin: 0 0 6px; color: #111827 !important; font-size: 16px; font-weight: 900 !important; }
.edit-role { display: inline-flex; align-items: center; min-height: 22px; margin-bottom: 8px; padding: 3px 9px; border-radius: 999px; background: #611232; color: #fff !important; font-size: 12px; font-weight: 900; }
.edit-preview span { display: block; color: #7a5364 !important; font-size: 12px; line-height: 1.4; }
.edit-alert { margin-bottom: 16px; padding: 12px 16px; border: 1px solid #f2c7cc; border-radius: 8px; background: #fff1f2; color: #7a1c28 !important; font-weight: 800; }
@media (max-width: 980px) {
    .edit-profile-layout { grid-template-columns: 1fr; }
    .edit-side { grid-row: auto; }
}
@media (max-width: 680px) {
    .edit-form-body { padding: 22px 18px 28px; }
    .edit-photo-box, .edit-grid { grid-template-columns: 1fr; }
    .edit-photo-box { align-items: flex-start; flex-direction: column; }
    .edit-back-link { width: 100%; margin-left: 0; justify-content: center; }
    .edit-btn { width: 100%; }
}
</style>

<div class="gob-dashboard">
    @include('frontend.home.inc.sidebar')

    <div class="gob-main">
        <section class="edit-profile-page" aria-labelledby="edit-profile-title">
            <nav class="edit-profile-breadcrumb" aria-label="Ruta de navegacion">
                <a href="{{ route('frontend.home') }}">Inicio</a>
                <span>&gt;</span>
                <a href="{{ route('profile.show') }}">Perfil de usuario</a>
                <span>&gt;</span>
                <strong>Editar perfil</strong>
            </nav>

            <header class="edit-profile-heading">
                <h1 id="edit-profile-title">Editar perfil</h1>
                <p>Actualiza la informacion general asociada a tu cuenta de Autor.</p>
            </header>

            @if($errors->any())
                <div class="edit-alert">Revise los campos marcados antes de continuar.</div>
            @endif

            <div class="edit-profile-layout">
                <form method="POST" action="{{ route('profile.update') }}" class="edit-profile-card">
                    @csrf
                    @method('PUT')

                    <div class="edit-form-head">Formulario de edicion</div>

                    <div class="edit-form-body">
                        <div class="edit-photo-box">
                            <span class="edit-avatar">{{ $initials }}</span>
                            <div class="edit-photo-meta">
                                <button type="button" class="edit-photo-btn">
                                    <i class="las la-camera" aria-hidden="true"></i>
                                    Cambiar foto
                                </button>
                                <span>La imagen sera visible dentro del sistema.</span>
                            </div>
                        </div>

                        <section class="edit-section">
                            <h2 class="edit-section-title">Datos personales</h2>
                            <div class="edit-grid">
                                <div class="edit-field">
                                    <label for="name">Nombre completo</label>
                                    <input id="name" type="text" name="name" value="{{ old('name', $user->name) }}" required>
                                    @error('name')<span class="edit-error">{{ $message }}</span>@enderror
                                </div>

                                <div class="edit-field">
                                    <label for="email">Correo electronico</label>
                                    <input id="email" type="email" name="email" value="{{ old('email', $user->email) }}" required>
                                    @error('email')<span class="edit-error">{{ $message }}</span>@enderror
                                </div>

                                <div class="edit-field">
                                    <label for="phone">Telefono</label>
                                    <input id="phone" type="text" name="phone" value="{{ old('phone', $user->phone ?? '') }}" placeholder="No registrado">
                                    @error('phone')<span class="edit-error">{{ $message }}</span>@enderror
                                </div>

                                <div class="edit-field">
                                    <label for="sex">Sexo</label>
                                    <input id="sex" type="text" name="sex" value="{{ old('sex', $user->sex ?? '') }}" placeholder="No especificado">
                                    @error('sex')<span class="edit-error">{{ $message }}</span>@enderror
                                </div>

                                <div class="edit-field">
                                    <label for="age">Edad</label>
                                    <input id="age" type="number" name="age" min="1" max="120" value="{{ old('age', $user->age ?? '') }}" placeholder="No especificada">
                                    @error('age')<span class="edit-error">{{ $message }}</span>@enderror
                                </div>
                            </div>
                        </section>

                        <section class="edit-section">
                            <h2 class="edit-section-title">Datos institucionales</h2>
                            <div class="edit-grid">
                                <div class="edit-field">
                                    <label for="institution">Empresa / Institucion</label>
                                    <input id="institution" type="text" name="institution" value="{{ old('institution', $user->institution ?? 'INIFAP') }}" placeholder="INIFAP">
                                    @error('institution')<span class="edit-error">{{ $message }}</span>@enderror
                                </div>

                                <div class="edit-field">
                                    <label for="department">Departamento</label>
                                    <input id="department" type="text" name="department" value="{{ old('department', $user->department ?? 'Investigacion y Desarrollo') }}" placeholder="Investigacion y Desarrollo">
                                    @error('department')<span class="edit-error">{{ $message }}</span>@enderror
                                </div>

                                <div class="edit-field">
                                    <label for="curp">CURP</label>
                                    <input id="curp" type="text" name="curp" maxlength="18" value="{{ old('curp', $user->curp ?? '') }}" placeholder="No registrada">
                                    @error('curp')<span class="edit-error">{{ $message }}</span>@enderror
                                </div>

                                <div class="edit-field">
                                    <label for="rfc">RFC</label>
                                    <input id="rfc" type="text" name="rfc" maxlength="13" value="{{ old('rfc', $user->rfc ?? '') }}" placeholder="No registrado">
                                    @error('rfc')<span class="edit-error">{{ $message }}</span>@enderror
                                </div>

                                <div class="edit-field">
                                    <label for="location">Ubicacion</label>
                                    <input id="location" type="text" name="location" value="{{ old('location', $user->location ?? 'Mexico') }}" placeholder="Mexico">
                                    @error('location')<span class="edit-error">{{ $message }}</span>@enderror
                                </div>
                            </div>
                        </section>

                        <section class="edit-section">
                            <h2 class="edit-section-title">Informacion adicional</h2>
                            <div class="edit-grid">
                                <div class="edit-field is-wide">
                                    <label for="about">Acerca de mi</label>
                                    <textarea id="about" name="about" placeholder="Escribe una breve descripcion de tu perfil...">{{ old('about', $user->about ?? '') }}</textarea>
                                    @error('about')<span class="edit-error">{{ $message }}</span>@enderror
                                </div>

                                <div class="edit-field is-wide">
                                    <label for="specialty">Area de especialidad</label>
                                    <textarea id="specialty" name="specialty" placeholder="Ej. Investigacion documental, gestion editorial...">{{ old('specialty', $user->specialty ?? '') }}</textarea>
                                    @error('specialty')<span class="edit-error">{{ $message }}</span>@enderror
                                </div>
                            </div>
                        </section>

                        <div class="edit-form-actions">
                            <button type="submit" class="edit-btn edit-btn-primary">
                                <i class="las la-save" aria-hidden="true"></i>
                                Guardar cambios
                            </button>
                            <a href="{{ route('profile.show') }}" class="edit-btn edit-btn-secondary">
                                <i class="las la-times" aria-hidden="true"></i>
                                Cancelar
                            </a>
                            <a href="{{ route('profile.show') }}" class="edit-back-link">
                                <i class="las la-arrow-left" aria-hidden="true"></i>
                                Volver al perfil
                            </a>
                        </div>
                    </div>
                </form>

                <aside class="edit-side">
                    <article class="edit-side-card edit-recommend">
                        <h2><i class="las la-info-circle" aria-hidden="true"></i> Recomendaciones</h2>
                        <ol class="edit-tips">
                            <li><span class="edit-tip-number">1</span><span>Manten tus datos actualizados.</span></li>
                            <li><span class="edit-tip-number">2</span><span>Usa un correo institucional cuando sea posible.</span></li>
                            <li><span class="edit-tip-number">3</span><span>La informacion sera utilizada para seguimiento documental.</span></li>
                        </ol>
                    </article>

                    <article class="edit-side-card edit-preview">
                        <span class="edit-avatar">{{ $initials }}</span>
                        <h2>{{ $name }}</h2>
                        <span class="edit-role">Autor</span>
                        <span>{{ $user->email }}</span>
                        <span>{{ $institution }}</span>
                    </article>
                </aside>
            </div>
        </section>
    </div>
</div>

@endsection
