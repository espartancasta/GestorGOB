@extends('frontend.master')

@section('title', 'Documentos pendientes')

@section('content')

<div class="gob-dashboard">

    @include('frontend.home.inc.sidebar')

    <div class="gob-main">

        <div class="gob-header">
            <h2>Documentos pendientes</h2>
            <p>Consulta todos los documentos enviados por autores y gestiona su seguimiento.</p>
        </div>

        <div style="
            background:#fff;
            border:1px solid rgba(0,0,0,.08);
            border-radius:12px;
            padding:25px;
            box-shadow:0 8px 24px rgba(0,0,0,.06);
            margin-top:20px;
        ">

            <h3 style="font-weight:700; margin-bottom:20px; color:#545454;">
                Documentos del sistema
            </h3>

            @if($submissions->isEmpty())

                <p style="color:#6c757d; margin:0;">
                    No hay documentos registrados.
                </p>

            @else

                <div class="table-responsive">
                    <table class="table table-bordered table-hover align-middle">

                        <thead style="background:#611232; color:#fff;">
                            <tr>
                                <th>ID</th>
                                <th>Título</th>
                                <th>Autor</th>
                                <th>Estado</th>
                                <th>Fecha</th>
                                <th>Revisores</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach($submissions as $submission)
                                <tr>
                                    <td>{{ $submission->id }}</td>
                                    <td>{{ $submission->title }}</td>
                                    <td>{{ $submission->author->name ?? 'N/A' }}</td>
                                    <td>{{ $submission->status }}</td>
                                    <td>{{ $submission->created_at->format('d/m/Y') }}</td>
                                    <td>{{ $submission->reviewers->count() }}</td>
                                    <td>
                                        <div style="display:flex; flex-wrap:wrap; gap:8px;">
                                            <a href="{{ route('submissions.show', $submission) }}"
                                               class="btn btn-sm btn-primary">
                                                Ver expediente
                                            </a>

                                            @if(in_array($submission->status, ['pending_assignment', 'waiting_acceptance'], true))
                                                <a href="{{ route('submissions.show', $submission) }}"
                                                   class="btn btn-sm btn-secondary">
                                                    Asignar revisores
                                                </a>
                                            @endif

                                            <a href="{{ route('submissions.chat.index', $submission) }}"
                                               class="btn btn-sm"
                                               style="background:#611232; color:#fff;">
                                                Chat
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>

                    </table>
                </div>

            @endif

        </div>

    </div>

</div>

@endsection
