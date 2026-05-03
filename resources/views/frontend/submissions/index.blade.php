@extends('frontend.master')

@section('title', 'Documentos pendientes')

@section('content')

<div class="gob-dashboard">

    {{-- SIDEBAR --}}
    @include('frontend.home.inc.sidebar')

    {{-- CONTENIDO --}}
    <div class="gob-main">

        <div class="gob-header">
            <h2>Documentos pendientes</h2>
            <p>Consulta los documentos enviados por autores y asigna revisores.</p>
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
                Documentos pendientes de asignación
            </h3>

            {{-- MENSAJE SI NO HAY DATOS --}}
            @if($submissions->isEmpty())

                <p style="color:#6c757d; margin:0;">
                    No hay documentos pendientes.
                </p>

            @else

                <div class="table-responsive">
                    <table class="table table-bordered table-hover">

                        <thead style="background:#611232; color:#fff;">
                            <tr>
                                <th>ID</th>
                                <th>Título</th>
                                <th>Autor</th>
                                <th>Fecha</th>
                                <th>Acción</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach($submissions as $submission)
                                <tr>
                                    <td>{{ $submission->id }}</td>

                                    <td>{{ $submission->title }}</td>

                                    <td>{{ $submission->author->name ?? 'N/A' }}</td>

                                    <td>{{ $submission->created_at->format('d/m/Y') }}</td>

                                    <td>
                                        <a href="{{ route('submissions.show', $submission->id) }}"
                                           class="btn btn-sm btn-primary">
                                            Ver
                                        </a>
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