@extends('frontend.master')

@section('title', 'Detalle del documento')

@section('content')

<style>
/* BOTÓN GOB */
.btn-gob {
    background-color: #611232;
    color: #fff !important;
    border: none;
}

.btn-gob:hover {
    background-color: #4a0e26;
    color: #fff !important;
}

/* ALERTA GOB */
.alert-gob {
    background-color: #e6f4ea;
    border-left: 5px solid #28a745;
    color: #155724;
}

/* TARJETAS */
.gob-detail-card {
    background: #fff;
    border: 1px solid rgba(0,0,0,.08);
    border-radius: 12px;
    padding: 25px;
    box-shadow: 0 8px 24px rgba(0,0,0,.06);
    margin-bottom: 25px;
}

.gob-detail-title {
    font-weight: 700;
    margin-bottom: 20px;
    color: #545454;
}
</style>

<div class="gob-dashboard">

    {{-- SIDEBAR NUEVO CORRECTO --}}
    @include('frontend.home.inc.sidebar')

    {{-- CONTENIDO --}}
    <div class="gob-main">

        <div class="gob-header">
            <h2>Detalle del documento</h2>
            <p>Consulta la información del envío y asigna revisores al documento.</p>
        </div>

        {{-- MENSAJES --}}
        @if(session('success'))
            <div class="alert alert-gob mb-4">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger mb-4">
                {{ session('error') }}
            </div>
        @endif

        {{-- TRAER REVISORES --}}
        @php
            $reviewers = \App\Models\User::where('role', 2)->get();
        @endphp

        {{-- ASIGNAR REVISORES --}}
        <div class="gob-detail-card">

            <h4 class="gob-detail-title">
                Asignar revisores
            </h4>

            <form method="POST" action="{{ route('submissions.assign', $submission->id) }}">
                @csrf

                <div class="row">

                    <div class="col-md-6 mb-3">
                        <label class="mb-2">
                            <b>Revisor 1</b>
                        </label>

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
                        <label class="mb-2">
                            <b>Revisor 2</b>
                        </label>

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

                <button type="submit" class="btn btn-gob mt-2">
                    Asignar revisores
                </button>

            </form>

        </div>

        {{-- DETALLE DEL DOCUMENTO --}}
        <div class="gob-detail-card">

            <h4 class="gob-detail-title">
                Información del documento
            </h4>

            <div class="table-responsive">
                <table class="table table-bordered align-middle">

                    <tbody>

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
                                @elseif($submission->status === 'pending_correction')
                                    Pendiente de corrección
                                @elseif($submission->status === 'final_review')
                                    Revisión final
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
                                    <span class="text-muted">
                                        No disponible
                                    </span>
                                @endif
                            </td>
                        </tr>

                    </tbody>

                </table>
            </div>

            <a href="{{ route('submissions.index') }}" class="btn btn-secondary mt-3">
                Regresar
            </a>

        </div>

    </div>

</div>

@endsection