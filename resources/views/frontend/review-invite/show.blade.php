@extends('frontend.master')

@section('content')

<div class="container mt-5">

    @if(isset($expired) && $expired)
        <div class="alert alert-danger">
            Esta invitación ha expirado.
        </div>
    @else

        <h3>Invitación a revisión</h3>

        <p><strong>Documento ID:</strong> {{ $invite->submission_id }}</p>
        <p><strong>Estado:</strong> {{ $invite->status }}</p>

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <form method="POST" action="{{ url('/review-invite/'.$invite->invite_token.'/reject') }}">
            @csrf
            <button class="btn btn-danger">Rechazar revisión</button>
        </form>

    @endif

</div>

@endsection