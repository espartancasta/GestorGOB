@extends("frontend.master")

@section("title", "Registrarse - ".config("app.name"))
@section("content")
<section class="login p-0 py-5">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-6 col-md-8 m-auto">
                <div class="login-content">
                    @if ($enable_registration)
                    <h4>Registrarse</h4>
                    @if ($errors->any())
                    <div class="alert alert-danger rounded-0">
                    @foreach ($errors->all() as $error)
                        <p>{{ $error }}</p>
                    @endforeach
                    </div>
                    @endif
                    <form action="{{ route("auth.signup") }}" class="sign-form widget-form contact_form" method="POST">
                        @csrf
                        <div class="form-group">
                            <input type="text" class="form-control" placeholder="Nombre Completo*" name="name" value="{{ old("name") }}"/>
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control" placeholder="Usuario*" name="username" value="{{ old("username") }}"/>
                        </div>
                        <div class="form-group">
                            <input type="email" class="form-control" placeholder="Correo Electrónico*" name="email" value="{{ old("email") }}"/>
                        </div>
                        <div class="form-group">
                            <input type="password" class="form-control" placeholder="Contraseña*" name="password"/>
                        </div>
                        <div class="form-group">
                            <input type="password" class="form-control" placeholder="Confirmar Contraseña*" name="password_confirmation"/>
                        </div>
                        <div class="sign-controls form-group">
                            <div class="custom-control custom-checkbox">
                                <input name="agree" value="1" type="checkbox" class="custom-control-input" id="terms"/>
                                <label class="custom-control-label" for="terms">Acepto los <a href="#" class="btn-link">términos y condiciones</a></label>
                            </div>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn-custom">Registrarse</button>
                        </div>
                        <p class="form-group text-center">¿Ya tienes una cuenta? <a href="{{ route("auth.login") }}" class="btn-link">Iniciar Sesión</a></p>
                    </form>
                    @else
                    <div class="alert alert-danger rounded-0 m-0">
                        <span>¡El registro de usuarios actualmente no está permitido!</span>
                    </div>
                    @endif
                </div>
            </div>
         </div>
    </div>
</section>
@endsection
