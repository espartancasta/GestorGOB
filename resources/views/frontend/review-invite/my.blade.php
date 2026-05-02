@extends('frontend.master')

@section('title', 'Mis invitaciones')

@section('content')

<style>
/* 🎨 BOTÓN GOB */
.btn-gob {
    background-color: #611232;
    color: #fff !important;
    border: none;
}
.btn-gob:hover {
    background-color: #4a0e26;
    color: #fff !important;
}

/* 🏷 BADGES DE ESTADO */
.badge-invited {
    background-color: #6c757d;
}

.badge-accepted {
    background-color: #198754;
}

.badge-rejected {
    background-color: #dc3545;
}

.badge-completed {
    background-color: #0dcaf0;
}
</style>

<div class="container mt-5">

    <h3 class="mb-4 fw-bold">Mis invitaciones</h3>

    @forelse($invites as $invite)

        <div class="card shadow-sm p-3 mt-3" style="border-radius:12px;">

            <h5 class="mb-2">
                {{ $invite->submission->title ?? 'Sin título' }}
            </h5>

            <p class="mb-2">
                Estado:
                <span class="badge
                    @if($invite->status === 'invited') badge-invited
                    @elseif($invite->status === 'accepted') badge-accepted
                    @elseif($invite->status === 'rejected') badge-rejected
                    @elseif($invite->status === 'completed') badge-completed
                    @endif
                ">
                    {{ $invite->status }}
                </span>
            </p>

            <div class="mt-2">
                <a href="{{ url('/review-invite/'.$invite->invite_token_hash) }}"
                   class="btn btn-gob btn-sm">
                    Ver invitación
                </a>
            </div>

        </div>

    @empty

        <div class="alert alert-info mt-3">
            No tienes invitaciones aún.
        </div>

    @endforelse

</div>

@endsection