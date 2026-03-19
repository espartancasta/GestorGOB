@extends('frontend.master')

@section('title', 'Detalle del documento')

@section('content')

<section class="blog-author mt-30 mb-30">
<div class="container-fluid">
<div class="row">

    {{-- CONTENIDO --}}
    <div class="col-lg-9 gob-main-content">

        <div style="
        background:#fff;
        border:1px solid rgba(0,0,0,.08);
        border-radius:12px;
        padding:30px;
        box-shadow:0 8px 24px rgba(0,0,0,.06);
        ">

            <h3 style="font-weight:700;margin-bottom:20px;">
                Detalle del documento
            </h3>

            <div class="mb-3">
                <label><b>ID</b></label>
                <div>{{ $submission->id }}</div>
            </div>

            <div class="mb-3">
                <label><b>Título</b></label>
                <div>{{ $submission->title }}</div>
            </div>

            <div class="mb-3">
                <label><b>Autor</b></label>
                <div>{{ $submission->author->name ?? 'N/A' }}</div>
            </div>

            <div class="mb-3">
                <label><b>Fecha de envío</b></label>
                <div>{{ $submission->created_at->format('d/m/Y H:i') }}</div>
            </div>

            <div class="mb-3">
                <label><b>Estado</b></label>
                <div>
                    @if($submission->status === 'pending_assignment')
                        Pendiente de asignación
                    @else
                        {{ $submission->status }}
                    @endif
                </div>
            </div>

            <div class="mb-4">
                <label><b>Resumen</b></label>
                <div style="
                    background:#f8f9fa;
                    border:1px solid #e9ecef;
                    border-radius:10px;
                    padding:15px;
                    white-space:pre-line;
                ">
                    {{ $submission->summary }}
                </div>
            </div>

            <div class="mb-4">
                <label><b>Archivo original</b></label>
                <div>
                    @if($originalFile)
                        <a href="{{ route('submissions.download', $submission->id) }}"
                           class="btn btn-sm btn-primary">
                            Descargar documento .docx
                        </a>
                    @else
                        <p style="color:#6c757d;">No se encontró archivo asociado.</p>
                    @endif
                </div>
            </div>

            <div class="d-flex gap-2">
                <a href="{{ route('submissions.index') }}"
                   class="btn btn-secondary">
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