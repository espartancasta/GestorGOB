@extends('frontend.master')

@section('title', 'Invitación expirada')

@section('content')

<div class="container mt-5 text-center">

    <div class="card shadow-sm p-4">

        <h3 class="text-danger mb-3">
            La invitación ha expirado
        </h3>

        <p class="text-muted">
            Este enlace ya no es válido o ha superado el tiempo permitido.
        </p>

        <a href="{{ route('frontend.home') }}" class="btn btn-primary mt-3">
            Volver al inicio
        </a>

    </div>

</div>

@endsection