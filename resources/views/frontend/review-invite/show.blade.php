@extends('frontend.master')

@section('title', 'Invitación de revisión')

@section('content')

<style>
/* 🎨 ESTILO GOB */
.btn-gob {
    background-color: #611232;
    color: #fff;
    border: none;
}
.btn-gob:hover {
    background-color: #4a0e26;
    color: #fff;
}

.alert-gob {
    background-color: #e6f4ea;
    border-left: 5px solid #28a745;
    color: #155724;
}
</style>

<div class="container mt-5">

    {{-- 🔴 EXPIRADA --}}
    @if(isset($expired) && $expired)

        <div class="card shadow-sm p-4 text-center">
            <h3 class="text-danger mb-3">Invitación expirada</h3>

            <p class="text-muted">
                Este enlace ya no es válido o ha superado el tiempo permitido.
            </p>

            <a href="{{ route('frontend.home') }}" class="btn btn-gob mt-3">
                Volver al inicio
            </a>
        </div>

    @else

        <div class="card shadow-sm p-4">

            <h3 class="mb-3 fw-bold">Invitación a revisión</h3>

            {{-- 🔥 MENSAJES --}}
            @if(session('success'))
                <div class="alert alert-gob mt-3">
                    ✔ {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger mt-3">
                    ❌ {{ session('error') }}
                </div>
            @endif

            {{-- 📄 INFO --}}
            <p><strong>ID Documento:</strong> {{ $invite->submission_id }}</p>

            <p><strong>Estado:</strong>
                <span class="badge bg-secondary">
                    {{ $invite->status }}
                </span>
            </p>

            @if(isset($invite->submission))
                <hr>
                <p><strong>Título:</strong> {{ $invite->submission->title }}</p>
                <p><strong>Resumen:</strong> {{ $invite->submission->summary }}</p>
            @endif

            {{-- 🔥 INVITED --}}
            @if($invite->status === 'invited')

                <div class="d-flex gap-2 mt-3">

                    <form method="POST" action="{{ url('/review-invite/'.$invite->invite_token_hash.'/accept') }}">
                        @csrf
                        <button class="btn btn-gob">
                            Aceptar revisión
                        </button>
                    </form>

                    <form method="POST" action="{{ url('/review-invite/'.$invite->invite_token_hash.'/reject') }}">
                        @csrf
                        <button class="btn btn-outline-danger">
                            Rechazar
                        </button>
                    </form>

                </div>

            {{-- 🔥 ACCEPTED --}}
            @elseif($invite->status === 'accepted')

                <div class="alert alert-gob mt-3">
                    ✔ Has aceptado la revisión
                </div>

                <hr>

                <h5>Subir revisión</h5>

                <form method="POST"
                      action="{{ url('/review-invite/'.$invite->invite_token_hash.'/upload-review') }}"
                      enctype="multipart/form-data">

                    @csrf

                    <div class="mb-3">
                        <input type="file" name="file" class="form-control" required>
                    </div>

                    <button class="btn btn-gob">
                        Subir revisión (.docx)
                    </button>

                </form>

            {{-- 🔥 COMPLETED --}}
            @elseif($invite->status === 'completed')

                <div class="alert alert-info mt-3">
                    ✔ Ya subiste tu revisión correctamente
                </div>

            {{-- 🔥 REJECTED --}}
            @elseif($invite->status === 'rejected')

                <div class="alert alert-danger mt-3">
                    ❌ Has rechazado esta revisión
                </div>

            @endif

        </div>

    @endif

</div>

@endsection