@extends('frontend.master')

@section('title', 'Detalle del documento')

@section('content')

<style>
/* 🎨 BOTÓN GOB */
.btn-gob {
    background-color: #611232;
    color: #fff;
    border: none;
}
.btn-gob:hover {
    background-color: #4a0e26;
    color: #fff;
}

/* 🔥 ALERTA BONITA */
.alert-gob {
    background-color: #e6f4ea;
    border-left: 5px solid #28a745;
    color: #155724;
}
</style>

<section class="mt-50 mb-50">
<div class="container-fluid">
<div class="row">

    <div class="col-lg-9 gob-main-content">

        {{-- 🔥 MENSAJES PRO --}}
        @if(session('success'))
            <div class="alert alert-gob mb-4">
                ✔ {{ session('success') ?? 'Invitación enviada correctamente 🔥' }}
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger mb-4">
                ❌ {{ session('error') }}
            </div>
        @endif

        {{-- 🔥 TRAER REVISORES --}}
        @php
            $reviewers = \App\Models\User::where('role', 2)->get();
        @endphp

        {{-- 🔥 CARD: ASIGNAR REVISORES --}}
        <div class="card mb-5 shadow-sm" style="border-radius:12px;">
            <div class="card-body">

                <h4 class="mb-4 fw-bold">
                    Asignar revisores
                </h4>

                <form method="POST" action="{{ route('submissions.assign', $submission->id) }}">
                    @csrf

                    <div class="row">

                        <div class="col-md-6 mb-3">
                            <label class="mb-2"><b>Revisor 1</b></label>
                            <select name="reviewers[]" class="form-control" required>
                                <option value="">Seleccionar revisor</option>
                                @foreach($reviewers as $user)
                                    <option value="{{ $user->id }}">
                                        {{ $user->name }} ({{ $user->email }})
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="mb-2"><b>Revisor 2</b></label>
                            <select name="reviewers[]" class="form-control" required>
                                <option value="">Seleccionar revisor</option>
                                @foreach($reviewers as $user)
                                    <option value="{{ $user->id }}">
                                        {{ $user->name }} ({{ $user->email }})
                                    </option>
                                @endforeach
                            </select>
                        </div>

                    </div>

                    <button class="btn btn-gob mt-2">
                        Asignar revisores
                    </button>

                </form>

            </div>
        </div>


        {{-- 🔥 DETALLE --}}
        <div class="card shadow-sm" style="border-radius:12px;">
            <div class="card-body">

                <h4 class="mb-4 fw-bold">
                    Detalle del documento
                </h4>

                <div class="table-responsive">
                    <table class="table table-bordered align-middle">

                        <tr>
                            <th style="width:30%">ID</th>
                            <td>{{ $submission->id }}</td>
                        </tr>

                        <tr>
                            <th>Título</th>
                            <td>{{ $submission->title }}</td>
                        </tr>

                        <tr>
                            <th>Autor</th>
                            <td>{{ $submission->author->name ?? 'N/A' }}</td>
                        </tr>

                        <tr>
                            <th>Fecha de envío</th>
                            <td>{{ $submission->created_at->format('d/m/Y H:i') }}</td>
                        </tr>

                        <tr>
                            <th>Estado</th>
                            <td>
                                @if($submission->status === 'pending_assignment')
                                    Pendiente de asignación
                                @elseif($submission->status === 'waiting_acceptance')
                                    Esperando aceptación de revisores
                                @elseif($submission->status === 'in_review')
                                    En revisión
                                @elseif($submission->status === 'completed')
                                    Completado
                                @else
                                    {{ $submission->status }}
                                @endif
                            </td>
                        </tr>

                        <tr>
                            <th>Resumen</th>
                            <td>{{ $submission->summary }}</td>
                        </tr>

                        <tr>
                            <th>Archivo</th>
                            <td>
                                @if($originalFile)
                                    <a href="{{ route('submissions.download', $submission->id) }}"
                                       class="btn btn-sm btn-gob">
                                        Descargar documento
                                    </a>
                                @else
                                    <span class="text-muted">No disponible</span>
                                @endif
                            </td>
                        </tr>

                    </table>
                </div>

                <a href="{{ route('submissions.index') }}" class="btn btn-secondary mt-3">
                    Regresar
                </a>

            </div>
        </div>

    </div>

    {{-- SIDEBAR --}}
    <div class="col-lg-3 gob-sidebar-col">
        @include('frontend.user.inc.sidebar')
    </div>

</div>
</div>
</section>

@endsection