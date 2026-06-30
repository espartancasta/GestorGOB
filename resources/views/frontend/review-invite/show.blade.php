@extends('frontend.master')

@section('title', 'Detalle de Revisión')

@push('styles')
    <link rel="stylesheet" href="{{ asset('assets/frontend/css/revisor-detalle.css') }}">
@endpush

@section('content')

@php
    $submission = $invite->submission;
    $originalFile = $submission?->files?->firstWhere('type', 'original_docx');
    $reviewFile = $submission?->files
        ?->where('type', 'review_docx')
        ->where('uploaded_by', auth()->id())
        ->sortByDesc('created_at')
        ->first();
    $keywords = is_array($submission?->palabras_clave) ? $submission->palabras_clave : [];

    $invitationLabels = [
        'invited' => 'Invitación pendiente',
        'accepted' => 'Invitación aceptada',
        'rejected' => 'Invitación rechazada',
        'expired' => 'Invitación expirada',
        'completed' => 'Revisión entregada',
    ];

    $invitationClasses = [
        'invited' => 'is-pending',
        'accepted' => 'is-accepted',
        'rejected' => 'is-rejected',
        'expired' => 'is-pending',
        'completed' => 'is-accepted',
    ];
@endphp

<div class="gob-dashboard">
    @include('frontend.home.inc.sidebar')

    <div class="gob-main">
        <section class="reviewer-detail-page">
            <header class="reviewer-detail-heading">
                <span class="reviewer-period">Periodo 2026</span>
                <h1>Detalle de Revisión</h1>
                <p>Consulte la información de la propuesta asignada, descargue el documento original y envíe su dictamen de revisión.</p>
                <span class="reviewer-rule" aria-hidden="true"></span>
            </header>

            @if(session('success'))
                <div class="reviewer-alert reviewer-alert-success">{{ session('success') }}</div>
            @endif

            @if(session('error'))
                <div class="reviewer-alert reviewer-alert-danger">{{ session('error') }}</div>
            @endif

            @if($errors->any())
                <div class="reviewer-alert reviewer-alert-danger">
                    <strong>Revise los siguientes campos:</strong>
                    <ul>
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if(isset($expired) && $expired)
                <article class="reviewer-card reviewer-expired-card">
                    <span class="reviewer-badge invitation is-rejected">Invitación expirada</span>
                    <h2>Esta invitación ya no está disponible</h2>
                    <p>El enlace superó el tiempo permitido para responder la invitación de revisión.</p>
                </article>
            @else
                <article class="reviewer-card reviewer-proposal-card">
                    <div class="reviewer-proposal-top">
                        <div>
                            <span class="reviewer-eyebrow">Propuesta asignada</span>
                            <h2>{{ $submission->titulo_publicacion ?? $submission->title ?? 'No registrado' }}</h2>
                        </div>
                        <div class="reviewer-status-stack">
                            <span class="reviewer-label">Estado de invitación</span>
                            <span class="reviewer-badge invitation {{ $invitationClasses[$invite->status] ?? 'is-pending' }}">
                                {{ $invitationLabels[$invite->status] ?? $invite->status }}
                            </span>
                            <span class="reviewer-label">Estado de dictamen</span>
                            <span class="reviewer-badge decision {{ $invite->reviewDecisionClass() }}">
                                {{ $invite->reviewDecisionLabel() }}
                            </span>
                        </div>
                    </div>

                    <div class="reviewer-meta-grid">
                        <div>
                            <span>ID de propuesta</span>
                            #{{ $submission->id ?? 'N/A' }}
                        </div>
                        <div>
                            <span>Tipo de publicación</span>
                            {{ $submission->tipo_publicacion ?? 'No registrado' }}
                        </div>
                        <div>
                            <span>Fecha de envío</span>
                            {{ $submission?->created_at ? $submission->created_at->format('d/m/Y') : 'No registrado' }}
                        </div>
                        <div>
                            <span>Fecha límite</span>
                            {{ $invite->review_due_at ? $invite->review_due_at->format('d/m/Y') : 'No registrado' }}
                        </div>
                        <div>
                            <span>Autor o autores</span>
                            {{ $submission->autores ?: ($submission->author->name ?? 'No registrado') }}
                        </div>
                        <div>
                            <span>Institución de adscripción</span>
                            {{ $submission->institucion_adscripcion ?? 'No registrado' }}
                        </div>
                    </div>
                </article>

                <article class="reviewer-card">
                    <h2 class="reviewer-section-title">Información académica</h2>
                    <div class="reviewer-academic-block">
                        <span class="reviewer-label">Resumen</span>
                        <p>{{ $submission->resumen ?? $submission->summary ?? 'No registrado' }}</p>
                    </div>

                    <div class="reviewer-academic-block">
                        <span class="reviewer-label">Palabras clave</span>
                        @if(count($keywords))
                            <div class="reviewer-keywords">
                                @foreach($keywords as $keyword)
                                    <span>{{ $keyword }}</span>
                                @endforeach
                            </div>
                        @else
                            <p>No registrado</p>
                        @endif
                    </div>
                </article>

                @if($invite->status === 'invited')
                    <article class="reviewer-card">
                        <h2 class="reviewer-section-title">Responder invitación</h2>
                        <p class="reviewer-muted">Antes de descargar el documento y subir dictamen, acepte o rechace esta invitación de revisión.</p>
                        <div class="reviewer-actions-grid">
                            <form method="POST" action="{{ route('review.accept', $invite->invite_token_hash) }}">
                                @csrf
                                <button type="submit" class="reviewer-primary-btn">Aceptar revisión</button>
                            </form>
                            <form method="POST" action="{{ route('review.reject', $invite->invite_token_hash) }}">
                                @csrf
                                <button type="submit" class="reviewer-danger-btn">Rechazar invitación</button>
                            </form>
                        </div>
                    </article>
                @endif

                <article class="reviewer-card">
                    <h2 class="reviewer-section-title">Documento original del Autor</h2>
                    <p class="reviewer-muted">Descargue el archivo original en formato Word (.docx) para realizar la revisión con observaciones, comentarios o control de cambios.</p>

                    <div class="reviewer-file-row">
                        <div>
                            <strong>{{ $originalFile->original_name ?? 'No registrado' }}</strong>
                            <span>Formato permitido: .docx</span>
                        </div>

                        @if($originalFile && in_array($invite->status, ['accepted', 'completed'], true))
                            <a href="{{ route('review.downloadOriginal', $invite->invite_token_hash) }}" class="reviewer-primary-link">
                                Descargar documento original (.docx)
                            </a>
                        @else
                            <span class="reviewer-disabled-note">Disponible después de aceptar la invitación</span>
                        @endif
                    </div>
                </article>

                @if($invite->status === 'accepted')
                    <article class="reviewer-card">
                        <h2 class="reviewer-section-title">Subir revisión</h2>
                        <p class="reviewer-muted">Seleccione el dictamen correspondiente y adjunte el archivo revisado en formato Word (.docx).</p>

                        @if($invite->review_due_at && now()->greaterThan($invite->review_due_at))
                            <div class="reviewer-alert reviewer-alert-danger">
                                La fecha límite para entregar esta revisión ya venció.
                            </div>
                        @endif

                        <form method="POST"
                              action="{{ route('review.uploadReview', $invite->invite_token_hash) }}"
                              enctype="multipart/form-data"
                              class="reviewer-upload-form"
                              id="reviewUploadForm">
                            @csrf

                            <label>
                                <span>Dictamen de revisión</span>
                                <select name="review_decision" required>
                                    <option value="en_revision" {{ old('review_decision', $invite->review_decision) === 'en_revision' ? 'selected' : '' }}>En revisión</option>
                                    <option value="aprobado" {{ old('review_decision', $invite->review_decision) === 'aprobado' ? 'selected' : '' }}>Aprobado</option>
                                    <option value="aprobado_observaciones" {{ old('review_decision', $invite->review_decision) === 'aprobado_observaciones' ? 'selected' : '' }}>Aprobado con observaciones</option>
                                    <option value="no_aprobado" {{ old('review_decision', $invite->review_decision) === 'no_aprobado' ? 'selected' : '' }}>No aprobado</option>
                                </select>
                            </label>

                            <label class="reviewer-dropzone" for="reviewFile">
                                <input type="file"
                                       id="reviewFile"
                                       name="file"
                                       accept=".docx,application/vnd.openxmlformats-officedocument.wordprocessingml.document"
                                       required>
                                <span class="reviewer-upload-icon"><i class="las la-upload"></i></span>
                                <strong>Arrastre un archivo o haga clic para seleccionarlo</strong>
                                <span>Solo se permite formato <b>.docx</b></span>
                                <em id="reviewFileName"></em>
                            </label>

                            <p id="reviewFileError" class="reviewer-error" hidden>Solo se permite adjuntar un archivo .docx.</p>

                            <button type="submit" class="reviewer-primary-btn">
                                Subir revisión (.docx)
                            </button>
                        </form>
                    </article>
                @endif

                @if($invite->status === 'completed')
                    <article class="reviewer-card">
                        <h2 class="reviewer-section-title">Revisión entregada</h2>
                        <p class="reviewer-muted">Su dictamen y archivo de revisión ya fueron recibidos por el sistema.</p>
                        <div class="reviewer-file-row">
                            <div>
                                <strong>{{ $reviewFile->original_name ?? 'Archivo de revisión registrado' }}</strong>
                                <span>Dictamen: {{ $invite->reviewDecisionLabel() }} · {{ $invite->review_uploaded_at ? $invite->review_uploaded_at->format('d/m/Y H:i') : 'Sin fecha' }}</span>
                            </div>
                            <span class="reviewer-badge decision {{ $invite->reviewDecisionClass() }}">{{ $invite->reviewDecisionLabel() }}</span>
                        </div>
                    </article>
                @endif

                @if($invite->status === 'rejected')
                    <article class="reviewer-card">
                        <span class="reviewer-badge invitation is-rejected">Invitación rechazada</span>
                        <p class="reviewer-muted" style="margin-top:12px;">Usted rechazó esta invitación de revisión.</p>
                    </article>
                @endif
            @endif
        </section>
    </div>
</div>

@endsection

@section('script')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const input = document.getElementById('reviewFile');
    const fileName = document.getElementById('reviewFileName');
    const fileError = document.getElementById('reviewFileError');
    const form = document.getElementById('reviewUploadForm');

    function isDocx(file) {
        return file && file.name.toLowerCase().endsWith('.docx');
    }

    if (input) {
        input.addEventListener('change', function () {
            const file = this.files[0];

            if (!file) {
                fileName.textContent = '';
                fileError.hidden = true;
                return;
            }

            if (!isDocx(file)) {
                this.value = '';
                fileName.textContent = '';
                fileError.hidden = false;
                return;
            }

            fileName.textContent = file.name;
            fileError.hidden = true;
        });
    }

    if (form) {
        form.addEventListener('submit', function (event) {
            if (input.files.length && !isDocx(input.files[0])) {
                event.preventDefault();
                fileError.hidden = false;
            }
        });
    }
});
</script>
@endsection
