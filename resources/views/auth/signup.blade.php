@extends("frontend.master")

@section("title", "Crear cuenta - " . config("app.name"))

@section("content")

<style>
.signup-page { padding: 30px 22px 56px; background: #f7f7f7; }
.signup-card { max-width: 1160px; margin: 0 auto; padding: 40px 40px 34px; border: 1px solid #dce2ea; border-radius: 10px; background: #fff; box-shadow: 0 8px 18px rgba(15,23,42,.06); }
.signup-heading { margin-bottom: 30px; }
.signup-heading h1 { margin: 0 0 10px; color: #020617 !important; font-size: 28px; font-weight: 900 !important; }
.signup-heading p { margin: 0; color: #334155 !important; font-size: 16px; }
.signup-section { margin-top: 30px; }
.signup-section-title { display: flex; align-items: center; gap: 9px; margin-bottom: 16px; padding-bottom: 12px; border-bottom: 1px solid #dfe5ec; color: #611232; font-size: 14px; font-weight: 900; letter-spacing: 1px; text-transform: uppercase; }
.signup-section-title i { color: #611232 !important; font-size: 17px; }
.signup-grid { display: grid; grid-template-columns: repeat(2, minmax(0, 1fr)); gap: 16px 20px; }
.signup-field { display: grid; gap: 7px; min-width: 0; }
.signup-field.is-wide { grid-column: 1 / -1; }
.signup-field label { margin: 0; color: #020617 !important; font-size: 14px; font-weight: 900; }
.signup-required { color: #b42318 !important; }
.signup-control { position: relative; }
.signup-control i { position: absolute; top: 50%; left: 14px; color: #94a3b8 !important; font-size: 18px; transform: translateY(-50%); pointer-events: none; }
.signup-control input,
.signup-control select,
.signup-field textarea {
    width: 100%;
    min-height: 38px !important;
    padding: 8px 14px 8px 40px !important;
    border: 1px solid #cbd5e1 !important;
    border-radius: 7px !important;
    background: #f8fafc !important;
    color: #020617 !important;
    font-size: 15px;
    outline: none;
}
.signup-control select { appearance: none; }
.signup-control input:focus,
.signup-control select:focus,
.signup-field textarea:focus { border-color: #611232 !important; box-shadow: 0 0 0 3px rgba(97,18,50,.08) !important; }
.signup-field textarea { min-height: 104px !important; padding: 12px 14px !important; resize: vertical; }
.signup-control input::placeholder,
.signup-field textarea::placeholder { color: #64748b !important; }
.signup-error { color: #b42318 !important; font-size: 12px; font-weight: 700; }
.signup-help { margin: 12px 0 0; color: #475569 !important; font-size: 14px; }
.signup-terms { display: flex; align-items: center; gap: 10px; margin: 28px 0 30px; color: #020617; font-size: 15px; font-weight: 800; }
.signup-terms input { width: 18px; height: 18px; accent-color: #611232; }
.signup-submit { display: inline-flex; align-items: center; justify-content: center; width: 100%; min-height: 48px; border: 0; border-radius: 8px; background: #611232; color: #fff !important; font-size: 15px; font-weight: 900; box-shadow: 0 8px 14px rgba(97,18,50,.2); cursor: pointer; }
.signup-submit:hover { background: #4b0d27; }
.signup-login { margin: 18px 0 0; color: #334155 !important; text-align: center; font-size: 14px; font-weight: 700; }
.signup-login a { color: #334155 !important; font-weight: 900; text-decoration: underline; }
.signup-alert { margin-bottom: 18px; padding: 12px 14px; border: 1px solid #f2c7cc; border-radius: 8px; background: #fff1f2; color: #7a1c28 !important; font-weight: 800; }
@media (max-width: 760px) {
    .signup-page { padding: 20px 12px 40px; }
    .signup-card { padding: 28px 18px; }
    .signup-grid { grid-template-columns: 1fr; }
}
</style>

<section class="signup-page">
    <div class="signup-card">
        @if ($enable_registration)
            <header class="signup-heading">
                <h1>Crear cuenta</h1>
                <p>Registra tu informacion para acceder al sistema de gestion documental.</p>
            </header>

            @if ($errors->any())
                <div class="signup-alert">Revise los campos marcados antes de continuar.</div>
            @endif

            <form action="{{ route('auth.signup.submit') }}" method="POST">
                @csrf

                <section class="signup-section">
                    <h2 class="signup-section-title"><i class="las la-shield-alt" aria-hidden="true"></i> Datos de acceso</h2>

                    <div class="signup-grid">
                        <div class="signup-field is-wide">
                            <label for="name">Nombre completo <span class="signup-required">*</span></label>
                            <div class="signup-control">
                                <i class="las la-user" aria-hidden="true"></i>
                                <input id="name" type="text" name="name" value="{{ old('name') }}" placeholder="Ingresa tu nombre completo" required>
                            </div>
                            @error('name')<span class="signup-error">{{ $message }}</span>@enderror
                        </div>

                        <div class="signup-field">
                            <label for="username">Usuario <span class="signup-required">*</span></label>
                            <div class="signup-control">
                                <i class="las la-user-circle" aria-hidden="true"></i>
                                <input id="username" type="text" name="username" value="{{ old('username') }}" placeholder="Nombre de usuario" required>
                            </div>
                            @error('username')<span class="signup-error">{{ $message }}</span>@enderror
                        </div>

                        <div class="signup-field">
                            <label for="email">Correo electronico <span class="signup-required">*</span></label>
                            <div class="signup-control">
                                <i class="las la-envelope" aria-hidden="true"></i>
                                <input id="email" type="email" name="email" value="{{ old('email') }}" placeholder="correo@ejemplo.com" required>
                            </div>
                            @error('email')<span class="signup-error">{{ $message }}</span>@enderror
                        </div>

                        <div class="signup-field">
                            <label for="password">Contrasena <span class="signup-required">*</span></label>
                            <div class="signup-control">
                                <i class="las la-lock" aria-hidden="true"></i>
                                <input id="password" type="password" name="password" placeholder="Contrasena segura" required>
                            </div>
                            @error('password')<span class="signup-error">{{ $message }}</span>@enderror
                        </div>

                        <div class="signup-field">
                            <label for="password_confirmation">Confirmar contrasena <span class="signup-required">*</span></label>
                            <div class="signup-control">
                                <i class="las la-lock" aria-hidden="true"></i>
                                <input id="password_confirmation" type="password" name="password_confirmation" placeholder="Confirma tu contrasena" required>
                            </div>
                            @error('password_confirmation')<span class="signup-error">{{ $message }}</span>@enderror
                        </div>
                    </div>
                </section>

                <section class="signup-section">
                    <h2 class="signup-section-title"><i class="las la-briefcase" aria-hidden="true"></i> Datos institucionales</h2>

                    <div class="signup-grid">
                        <div class="signup-field">
                            <label for="role_id">Rol solicitado <span class="signup-required">*</span></label>
                            <div class="signup-control">
                                <i class="las la-id-badge" aria-hidden="true"></i>
                                <select id="role_id" name="role_id" required>
                                    <option value="1" {{ old('role_id', '1') == '1' ? 'selected' : '' }}>Autor</option>
                                </select>
                            </div>
                            @error('role_id')<span class="signup-error">{{ $message }}</span>@enderror
                        </div>

                        <div class="signup-field">
                            <label for="institution">Empresa / Institucion</label>
                            <div class="signup-control">
                                <i class="las la-building" aria-hidden="true"></i>
                                <input id="institution" type="text" name="institution" value="{{ old('institution', 'INIFAP') }}" placeholder="INIFAP">
                            </div>
                            @error('institution')<span class="signup-error">{{ $message }}</span>@enderror
                        </div>

                        <div class="signup-field">
                            <label for="department">Departamento</label>
                            <div class="signup-control">
                                <i class="las la-sitemap" aria-hidden="true"></i>
                                <input id="department" type="text" name="department" value="{{ old('department') }}" placeholder="Departamento">
                            </div>
                            @error('department')<span class="signup-error">{{ $message }}</span>@enderror
                        </div>

                        <div class="signup-field">
                            <label for="specialty">Area de especialidad</label>
                            <div class="signup-control">
                                <i class="las la-book" aria-hidden="true"></i>
                                <input id="specialty" type="text" name="specialty" value="{{ old('specialty') }}" placeholder="Area de especialidad">
                            </div>
                            @error('specialty')<span class="signup-error">{{ $message }}</span>@enderror
                        </div>

                        <div class="signup-field">
                            <label for="location">Ubicacion</label>
                            <div class="signup-control">
                                <i class="las la-map-marker" aria-hidden="true"></i>
                                <select id="location" name="location">
                                    <option value="Mexico" {{ old('location', 'Mexico') === 'Mexico' ? 'selected' : '' }}>Mexico</option>
                                </select>
                            </div>
                            @error('location')<span class="signup-error">{{ $message }}</span>@enderror
                        </div>
                    </div>
                </section>


                <section class="signup-section">
                    <h2 class="signup-section-title"><i class="las la-clipboard-list" aria-hidden="true"></i> Informacion adicional</h2>

                    <div class="signup-field">
                        <label for="about">Acerca de mi</label>
                        <textarea id="about" name="about" placeholder="Cuentanos un poco sobre ti y tu experiencia profesional...">{{ old('about') }}</textarea>
                        @error('about')<span class="signup-error">{{ $message }}</span>@enderror
                    </div>

                    <p class="signup-help">Estos datos se utilizaran para completar tu perfil y dar seguimiento a tus propuestas dentro de GestorGOB.</p>
                </section>

                <label class="signup-terms" for="terms">
                    <input id="terms" type="checkbox" name="terms" value="1" {{ old('terms') ? 'checked' : '' }} required>
                    <span>Acepto los terminos y condiciones <span class="signup-required">*</span></span>
                </label>
                @error('terms')<span class="signup-error">{{ $message }}</span>@enderror

                <button type="submit" class="signup-submit">Registrarse</button>

                <p class="signup-login">Â¿Ya tienes cuenta? <a href="{{ route('auth.login') }}">Iniciar sesion</a></p>
            </form>
        @else
            <div class="signup-alert">El registro de usuarios actualmente no esta permitido.</div>
        @endif
    </div>
</section>

@endsection
