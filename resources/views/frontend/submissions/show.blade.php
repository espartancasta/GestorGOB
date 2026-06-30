@extends('frontend.master')

@section('title', 'Detalle del documento')

@section('content')

<style>
/* =========================================================
   DETALLE DEL DOCUMENTO - GESTORGOB
========================================================= */

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

/* =========================================================
   SEMANA 19 - AUTOR DESCARGA REVISIONES RECIBIDAS
========================================================= */

.author-reviews-card {
    background: #ffffff;
    border: 1px solid #e6e6e6;
    border-left: 5px solid #611232;
    border-radius: 18px;
    padding: 24px;
    margin-top: 28px;
    box-shadow: 0 10px 24px rgba(0,0,0,0.04);
}

.author-reviews-header {
    margin-bottom: 20px;
}

.author-reviews-header h4 {
    color: #1f2937;
    font-weight: 900;
    margin-bottom: 8px;
}

.author-reviews-header p {
    color: #667085;
    margin: 0;
    line-height: 1.6;
}

.author-review-status {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    background: #f4f0f2;
    color: #611232;
    border: 1px solid #eadbe2;
    border-radius: 999px;
    padding: 8px 14px;
    font-size: 13px;
    font-weight: 900;
    margin-top: 14px;
}

.author-review-list {
    display: grid;
    grid-template-columns: repeat(2, minmax(0, 1fr));
    gap: 18px;
    margin-top: 20px;
}

.author-review-item {
    background: #f9fafb;
    border: 1px solid #edf0f2;
    border-radius: 16px;
    padding: 18px;
}

.author-review-item h5 {
    color: #1f2937;
    font-weight: 900;
    margin-bottom: 8px;
}

.author-review-item p {
    color: #667085;
    font-size: 14px;
    margin-bottom: 14px;
    line-height: 1.5;
}

.author-review-meta {
    color: #667085;
    font-size: 13px;
    font-weight: 700;
    margin-bottom: 14px;
}

.author-review-btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    width: 100%;
    min-height: 46px;
    border-radius: 12px;
    background: #235B4E;
    color: #ffffff !important;
    font-weight: 900;
    text-decoration: none !important;
}

.author-review-btn:hover {
    background: #13322E;
    color: #ffffff !important;
    text-decoration: none !important;
}

.author-reviews-empty {
    background: #fff8e6;
    border: 1px solid #f4d27b;
    color: #6b4e00;
    border-radius: 14px;
    padding: 16px;
    font-weight: 700;
    margin-top: 18px;
}

.author-reviews-note {
    background: #f9fafb;
    border: 1px solid #edf0f2;
    border-radius: 14px;
    padding: 16px;
    color: #667085;
    font-size: 14px;
    line-height: 1.6;
    margin-top: 20px;
}

/* =========================================================
   SEMANA 20 - AUTOR SUBE VERSIÓN CORREGIDA V2
========================================================= */

.author-corrected-card {
    background: #ffffff;
    border: 1px solid #e6e6e6;
    border-left: 5px solid #235B4E;
    border-radius: 18px;
    padding: 24px;
    margin-top: 28px;
    box-shadow: 0 10px 24px rgba(0,0,0,0.04);
}

.author-corrected-header h4 {
    color: #1f2937;
    font-weight: 900;
    margin-bottom: 8px;
}

.author-corrected-header p {
    color: #667085;
    margin: 0;
    line-height: 1.6;
}

.author-corrected-info {
    background: #f9fafb;
    border: 1px solid #edf0f2;
    border-radius: 14px;
    padding: 16px;
    color: #667085;
    font-size: 14px;
    line-height: 1.6;
    margin-top: 18px;
    margin-bottom: 18px;
}

.author-corrected-input {
    width: 100%;
    min-height: 48px;
    border: 1px solid #d0d5dd;
    border-radius: 12px;
    padding: 10px;
    background: #ffffff;
    margin-bottom: 16px;
}

.author-corrected-btn {
    width: 100%;
    min-height: 48px;
    border: none;
    border-radius: 12px;
    background: #611232;
    color: #ffffff !important;
    font-weight: 900;
    cursor: pointer;
    transition: all .2s ease;
}

.author-corrected-btn:hover {
    background: #4a0e26;
    color: #ffffff !important;
}

/* =========================================================
   SEMANA 21 - SECRETARIO REVISA DOCUMENTO CORREGIDO V2
========================================================= */

.secretary-final-card {
    background: #ffffff;
    border: 1px solid #e6e6e6;
    border-left: 5px solid #611232;
    border-radius: 18px;
    padding: 24px;
    margin-top: 28px;
    box-shadow: 0 10px 24px rgba(0,0,0,0.04);
}

.secretary-final-header h4 {
    color: #1f2937;
    font-weight: 900;
    margin-bottom: 8px;
}

.secretary-final-header p {
    color: #667085;
    margin: 0;
    line-height: 1.6;
}

.secretary-final-status {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    background: #f4f0f2;
    color: #611232;
    border: 1px solid #eadbe2;
    border-radius: 999px;
    padding: 8px 14px;
    font-size: 13px;
    font-weight: 900;
    margin-top: 14px;
}

.secretary-final-box {
    background: #f9fafb;
    border: 1px solid #edf0f2;
    border-radius: 16px;
    padding: 18px;
    margin-top: 20px;
}

.secretary-final-box h5 {
    color: #1f2937;
    font-weight: 900;
    margin-bottom: 8px;
}

.secretary-final-box p {
    color: #667085;
    font-size: 14px;
    line-height: 1.5;
    margin-bottom: 14px;
}

.secretary-final-meta {
    color: #667085;
    font-size: 13px;
    font-weight: 700;
    margin-bottom: 14px;
}

.secretary-final-btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    width: 100%;
    min-height: 46px;
    border-radius: 12px;
    background: #235B4E;
    color: #ffffff !important;
    font-weight: 900;
    text-decoration: none !important;
}

.secretary-final-btn:hover {
    background: #13322E;
    color: #ffffff !important;
    text-decoration: none !important;
}

.secretary-final-empty {
    background: #fff8e6;
    border: 1px solid #f4d27b;
    color: #6b4e00;
    border-radius: 14px;
    padding: 16px;
    font-weight: 700;
    margin-top: 18px;
}

.secretary-final-note {
    background: #f9fafb;
    border: 1px solid #edf0f2;
    border-radius: 14px;
    padding: 16px;
    color: #667085;
    font-size: 14px;
    line-height: 1.6;
    margin-top: 20px;
}

/* =========================================================
   SEMANA 22 - SECRETARIO RECHAZA CON OBSERVACIONES
========================================================= */

.secretary-decision-grid {
    display: grid;
    grid-template-columns: repeat(2, minmax(0, 1fr));
    gap: 18px;
    margin-top: 22px;
}

.secretary-reject-card {
    background: #ffffff;
    border: 1px solid #f0d6d6;
    border-left: 5px solid #9F2241;
    border-radius: 18px;
    padding: 22px;
    box-shadow: 0 8px 20px rgba(0,0,0,0.035);
}

.secretary-reject-card h5 {
    color: #1f2937;
    font-weight: 900;
    margin-bottom: 8px;
}

.secretary-reject-card p {
    color: #667085;
    font-size: 14px;
    line-height: 1.5;
    margin-bottom: 14px;
}

.secretary-reject-textarea {
    width: 100%;
    min-height: 120px;
    border: 1px solid #d0d5dd;
    border-radius: 12px;
    padding: 12px;
    resize: vertical;
    margin-bottom: 14px;
}

.secretary-reject-btn {
    width: 100%;
    min-height: 46px;
    border: none;
    border-radius: 12px;
    background: #9F2241;
    color: #ffffff !important;
    font-weight: 900;
    cursor: pointer;
}

.secretary-reject-btn:hover {
    background: #611232;
    color: #ffffff !important;
}

/* =========================================================
   SEMANA 23 - SECRETARIO APRUEBA / PANTALLA COMPLETED
========================================================= */

.secretary-approve-card {
    background: #ffffff;
    border: 1px solid #d7e7dc;
    border-left: 5px solid #235B4E;
    border-radius: 18px;
    padding: 22px;
    box-shadow: 0 8px 20px rgba(0,0,0,0.035);
}

.secretary-approve-card h5 {
    color: #1f2937;
    font-weight: 900;
    margin-bottom: 8px;
}

.secretary-approve-card p {
    color: #667085;
    font-size: 14px;
    line-height: 1.5;
    margin-bottom: 14px;
}

.secretary-approve-btn {
    width: 100%;
    min-height: 46px;
    border: none;
    border-radius: 12px;
    background: #235B4E;
    color: #ffffff !important;
    font-weight: 900;
    cursor: pointer;
}

.secretary-approve-btn:hover {
    background: #13322E;
    color: #ffffff !important;
}

.completed-card {
    background: #ffffff;
    border: 1px solid #d7e7dc;
    border-left: 5px solid #235B4E;
    border-radius: 18px;
    padding: 24px;
    margin-top: 28px;
    box-shadow: 0 10px 24px rgba(0,0,0,0.04);
}

.completed-header h4 {
    color: #1f2937;
    font-weight: 900;
    margin-bottom: 8px;
}

.completed-header p {
    color: #667085;
    margin: 0;
    line-height: 1.6;
}

.completed-status {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    background: #e9f5ef;
    color: #235B4E;
    border: 1px solid #b8dec7;
    border-radius: 999px;
    padding: 8px 14px;
    font-size: 13px;
    font-weight: 900;
    margin-top: 14px;
}

.carta-preview {
    background: #f9fafb;
    border: 1px solid #edf0f2;
    border-radius: 18px;
    padding: 22px;
    margin-top: 20px;
}

.carta-preview-inner {
    background: #ffffff;
    border: 1px solid #e5e7eb;
    border-radius: 14px;
    padding: 24px;
}

.carta-preview-inner h5 {
    color: #611232;
    font-weight: 900;
    text-align: center;
    margin-bottom: 18px;
}

.carta-preview-inner p {
    color: #4b5563;
    line-height: 1.7;
    margin-bottom: 12px;
}

.carta-preview-meta {
    background: #f4f0f2;
    border-radius: 12px;
    padding: 12px 14px;
    color: #611232;
    font-weight: 800;
    margin-top: 14px;
}

.carta-btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 100%;
    min-height: 46px;
    border-radius: 12px;
    background: #611232;
    color: #ffffff !important;
    font-weight: 900;
    text-decoration: none !important;
    margin-top: 16px;
}

.carta-btn:hover {
    background: #4a0e26;
    color: #ffffff !important;
}

@media (max-width: 768px) {
    .author-review-list,
    .secretary-decision-grid {
        grid-template-columns: 1fr;
    }
}
</style>

@php
    /*
        Protección para evitar errores si el controlador no manda $originalFile.
        Si ya lo manda, se usa el mismo.
        Si no lo manda, se busca dentro de los archivos del submission.
    */
    $originalFile = $originalFile ?? $submission->files->firstWhere('type', 'original_docx');

    /*
        Semana 19:
        Archivos de revisión subidos por revisores.
        El backend después conectará la descarga segura real.
    */
    $reviewFiles = $submission->files
        ->where('type', 'review_docx')
        ->values();

    /*
        Semana 21:
        Archivo corregido v2 subido por el Autor.
        El backend después conectará la descarga segura real.
    */
    $correctedFile = $submission->files
        ->where('type', 'corrected_v2_docx')
        ->sortByDesc('created_at')
        ->first();

    /*
        Semana 23/24:
        Carta Aval PDF. En Semana 23 solo se muestra preview.
        El PDF real corresponde a Semana 24.
    */
    $cartaAvalFile = $submission->files
        ->where('type', 'carta_aval_pdf')
        ->sortByDesc('created_at')
        ->first();
@endphp

<div class="gob-dashboard">

    {{-- SIDEBAR NUEVO CORRECTO --}}
    @include('frontend.home.inc.sidebar')

    {{-- CONTENIDO --}}
    <div class="gob-main">

        <div class="gob-header">
            <h2>Detalle del documento</h2>

            @if(auth()->check() && auth()->user()->role == 3)
                <p>Consulta la información del envío, revisiones y revisión final del documento.</p>
            @else
                <p>Consulta la información de tu documento y el avance del proceso de revisión.</p>
            @endif
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

        {{-- ASIGNAR REVISORES - SOLO SECRETARIO --}}
        @if(auth()->check() && auth()->user()->role == 3)

            @if(in_array($submission->status, ['pending_assignment', 'waiting_acceptance']))

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

            @endif

        @endif

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
                            <th>Archivo original</th>
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

                        <tr>
                            <th>Chat de seguimiento</th>
                            <td>
                                <a href="{{ route('submissions.chat.index', $submission) }}"
                                   class="btn btn-sm btn-gob">
                                    Abrir chat
                                </a>
                            </td>
                        </tr>

                    </tbody>

                </table>
            </div>

            {{-- =========================================================
                SEMANA 19 - AUTOR DESCARGA REVISIONES RECIBIDAS
            ========================================================= --}}

            @if(auth()->check() && auth()->user()->role == 1 && auth()->id() == $submission->author_id)

                @if(in_array($submission->status, ['pending_correction', 'final_review', 'completed']))

                    <div class="author-reviews-card">

                        <div class="author-reviews-header">
                            <h4>Revisiones recibidas</h4>

                            <p>
                                Los revisores ya entregaron sus archivos de revisión.
                                Descarga ambos documentos para revisar las observaciones y preparar tu versión corregida.
                            </p>

                            <span class="author-review-status">
                                {{ $reviewFiles->count() }} de 2 revisiones disponibles
                            </span>
                        </div>

                        @if($reviewFiles->count() > 0)

                            <div class="author-review-list">

                                @foreach($reviewFiles as $index => $reviewFile)

                                    <div class="author-review-item">

                                        <h5>Revisión del Revisor {{ $index + 1 }}</h5>

                                        <p>
                                            Archivo de revisión en formato Word (.docx) con observaciones,
                                            comentarios o control de cambios.
                                        </p>

                                        <div class="author-review-meta">
                                            Entrega registrada:
                                            {{ $reviewFile->created_at ? $reviewFile->created_at->format('d/m/Y H:i') : 'Sin fecha registrada' }}
                                        </div>

                                        <a href="{{ url('/submissions/'.$submission->id.'/reviews/'.$reviewFile->id.'/download') }}"
                                           class="author-review-btn">
                                            Descargar revisión (.docx)
                                        </a>

                                    </div>

                                @endforeach

                            </div>

                            <div class="author-reviews-note">
                                Después de revisar los archivos de ambos revisores, deberás preparar
                                la versión corregida del documento para continuar con la siguiente fase del proceso.
                            </div>

                        @else

                            <div class="author-reviews-empty">
                                Todavía no hay archivos de revisión disponibles para descargar.
                            </div>

                        @endif

                    </div>

                @endif

            @endif

            {{-- =========================================================
                SEMANA 20 - AUTOR SUBE DOCUMENTO CORREGIDO V2
            ========================================================= --}}

            @if(auth()->check() && auth()->user()->role == 1 && auth()->id() == $submission->author_id)

                @if($submission->status === 'pending_correction')

                    <div class="author-corrected-card">

                        <div class="author-corrected-header">
                            <h4>Subir versión corregida del documento</h4>

                            <p>
                                Después de revisar las observaciones de los revisores, adjunta la versión corregida
                                de tu documento en formato Word (.docx).
                            </p>
                        </div>

                        <div class="author-corrected-info">
                            Esta versión será registrada como documento corregido v2 y permitirá continuar
                            con la fase de revisión final por parte del Secretario.
                        </div>

                        <form method="POST"
                              action="{{ url('/submissions/'.$submission->id.'/corrected') }}"
                              enctype="multipart/form-data">

                            @csrf

                            <input type="file"
                                   name="file"
                                   class="author-corrected-input"
                                   accept=".docx,application/vnd.openxmlformats-officedocument.wordprocessingml.document"
                                   required>

                            <button type="submit" class="author-corrected-btn">
                                Subir versión corregida (.docx)
                            </button>

                        </form>

                    </div>

                @endif

            @endif

            {{-- =========================================================
                SEMANA 21, 22 Y 23 - SECRETARIO: REVISIÓN FINAL
            ========================================================= --}}

            @if(auth()->check() && auth()->user()->role == 3)

                @if($submission->status === 'final_review')

                    <div class="secretary-final-card">

                        <div class="secretary-final-header">
                            <h4>Revisión final del Secretario</h4>

                            <p>
                                El Autor ya subió la versión corregida del documento.
                                Revisa el archivo v2 antes de emitir una decisión final.
                            </p>

                            <span class="secretary-final-status">
                                Documento en revisión final
                            </span>
                        </div>

                        @if($correctedFile)

                            <div class="secretary-final-box">

                                <h5>Documento corregido v2</h5>

                                <p>
                                    Archivo Word (.docx) enviado por el Autor después de revisar las observaciones
                                    realizadas por los revisores.
                                </p>

                                <div class="secretary-final-meta">
                                    Fecha de carga:
                                    {{ $correctedFile->created_at ? $correctedFile->created_at->format('d/m/Y H:i') : 'Sin fecha registrada' }}
                                </div>

                                <a href="{{ url('/submissions/'.$submission->id.'/corrected/'.$correctedFile->id.'/download') }}"
                                   class="secretary-final-btn">
                                    Descargar versión corregida (.docx)
                                </a>

                            </div>

                            <div class="secretary-final-note">
                                Después de revisar el documento corregido, selecciona si se rechaza con observaciones
                                o si se aprueba para continuar con la Carta Aval.
                            </div>

                        @else

                            <div class="secretary-final-empty">
                                El documento está en revisión final, pero todavía no se encontró el archivo corregido v2.
                            </div>

                        @endif

                        <div class="secretary-decision-grid">

                            {{-- SEMANA 22 - RECHAZO FINAL --}}
                            <div class="secretary-reject-card">

                                <h5>Rechazar con observaciones</h5>

                                <p>
                                    Usa esta opción si el documento todavía requiere correcciones.
                                    El proceso regresará al Autor para una nueva versión corregida.
                                </p>

                                <form method="POST"
                                      action="{{ url('/submissions/'.$submission->id.'/final-reject') }}">

                                    @csrf

                                    <textarea name="final_notes"
                                              class="secretary-reject-textarea"
                                              placeholder="Escribe las observaciones para el Autor..."
                                              required>{{ old('final_notes', $submission->final_notes ?? '') }}</textarea>

                                    <button type="submit" class="secretary-reject-btn">
                                        Enviar rechazo al Autor
                                    </button>

                                </form>

                            </div>

                            {{-- SEMANA 23 - APROBACIÓN FINAL --}}
                            <div class="secretary-approve-card">

                                <h5>Aprobar documento</h5>

                                <p>
                                    Usa esta opción si el documento corregido cumple con los requisitos.
                                    El expediente quedará listo para la generación de la Carta Aval.
                                </p>

                                <form method="POST"
                                      action="{{ url('/submissions/'.$submission->id.'/final-approve') }}">

                                    @csrf

                                    <button type="submit" class="secretary-approve-btn">
                                        Aprobar documento
                                    </button>

                                </form>

                            </div>

                        </div>

                    </div>

                @endif

            @endif

            {{-- =========================================================
                SEMANA 23 - VISTA FINAL APROBADA / COMPLETED
            ========================================================= --}}

            @if($submission->status === 'completed')

                @if(auth()->check() && (auth()->user()->role == 3 || auth()->id() == $submission->author_id))

                    <div class="completed-card">

                        <div class="completed-header">
                            <h4>Documento aprobado</h4>

                            <p>
                                El documento completó el proceso de revisión y fue aprobado.
                                Esta sección muestra una vista previa de la Carta Aval.
                            </p>

                            <span class="completed-status">
                                Estado: Completado
                            </span>
                        </div>

                        <div class="carta-preview">

                            <div class="carta-preview-inner">

                                <h5>Vista previa de Carta Aval</h5>

                                <p>
                                    Por medio de la presente, se hace constar que el documento titulado
                                    <strong>{{ $submission->title }}</strong>, registrado por
                                    <strong>{{ $submission->author->name ?? 'Autor no disponible' }}</strong>,
                                    ha concluido satisfactoriamente el proceso de revisión.
                                </p>

                                <p>
                                    El documento fue revisado dentro del flujo institucional de GestorGOB
                                    y queda aprobado para continuar con el cierre formal del expediente.
                                </p>

                                <div class="carta-preview-meta">
                                    Documento ID: {{ $submission->id }} |
                                    Fecha de cierre:
                                    {{ $submission->updated_at ? $submission->updated_at->format('d/m/Y') : 'Sin fecha registrada' }}
                                </div>

                            </div>

                            @if($cartaAvalFile)

                                <a href="{{ url('/submissions/'.$submission->id.'/carta-aval/download') }}"
                                   class="carta-btn">
                                    Descargar Carta Aval PDF
                                </a>

                            @else

                                <a href="{{ url('/submissions/'.$submission->id.'/carta-aval/preview') }}"
                                   class="carta-btn">
                                    Vista preparada para Carta Aval
                                </a>

                            @endif

                        </div>

                    </div>

                @endif

            @endif

            {{-- BOTÓN REGRESAR SEGURO POR ROL --}}
            @if(auth()->check() && auth()->user()->role == 3)
                <a href="{{ route('submissions.index') }}" class="btn btn-secondary mt-3">
                    Regresar
                </a>
            @else
                <a href="{{ route('frontend.home') }}" class="btn btn-secondary mt-3">
                    Regresar
                </a>
            @endif

        </div>

    </div>

</div>

@endsection
