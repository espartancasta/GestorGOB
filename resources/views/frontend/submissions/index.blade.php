@extends('frontend.master')

@section('title', 'Documentos pendientes')

@section('content')

<section class="blog-author mt-30 mb-30">
<div class="container-fluid">
<div class="row">

    {{-- SIDEBAR --}}
    <div class="col-lg-4 order-lg-1 order-2">
        @include('frontend.user.inc.sidebar')
    </div>

    {{-- CONTENIDO --}}
    <div class="col-lg-8 order-lg-2 order-1">

        <div style="
        background:#fff;
        border:1px solid rgba(0,0,0,.08);
        border-radius:12px;
        padding:25px;
        box-shadow:0 8px 24px rgba(0,0,0,.06);
        ">

        <h3 style="font-weight:700;margin-bottom:20px;">
        Documentos pendientes de asignación
        </h3>

        {{-- MENSAJE SI NO HAY DATOS --}}
        @if($submissions->isEmpty())
            <p style="color:#6c757d;">
                No hay documentos pendientes.
            </p>
        @else

        <div class="table-responsive">
        <table class="table table-bordered table-hover">

            <thead style="background:#611232;color:#fff;">
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

                        <td>
                            {{ $submission->title }}
                        </td>

                        <td>
                            {{ $submission->author->name ?? 'N/A' }}
                        </td>

                        <td>
                            {{ $submission->created_at->format('d/m/Y') }}
                        </td>

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
</div>
</section>

@endsection