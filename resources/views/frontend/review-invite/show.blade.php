@extends('frontend.master')

@section('title', 'Invitación de revisión')

@section('content')

<style>
/* =========================================================
   DETALLE DE INVITACIÓN - REVISOR / GESTORGOB
========================================================= */

.review-show-page {
    max-width: 980px;
    margin: 0 auto;
    padding: 34px 20px 70px;
}

.review-back-link {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    color: #545454 !important;
    text-decoration: none !important;
    font-weight: 700;
    margin-bottom: 24px;
}

.review-back-link:hover {
    color: #611232 !important;
}

.review-hero {
    background: linear-gradient(135deg, #611232, #9F2241);
    border-radius: 22px 22px 0 0;
    padding: 34px;
    color: #fff;
    box-shadow: 0 14px 34px rgba(0,0,0,0.10);
}

.review-hero-top {
    display: flex;
    align-items: center;
    gap: 16px;
    margin-bottom: 24px;
}

.review-hero-icon {
    width: 64px;
    height: 64px;
    border-radius: 18px;
    background: rgba(255,255,255,0.18);
    display: inline-flex;
    align-items: center;
    justify-content: center;
    font-size: 34px;
}

.review-hero-id {
    display: inline-flex;
    align-items: center;
    min-height: 32px;
    padding: 0 14px;
    border-radius: 999px;
    background: rgba(255,255,255,0.18);
    font-weight: 800;
    font-size: 14px;
}

.review-hero h2 {
    color: #fff !important;
    font-size: 34px;
    font-weight: 900;
    line-height: 1.25;
    margin: 0 0 10px 0;
}

.review-hero p {
    color: rgba(255,255,255,0.88) !important;
    margin: 0;
    font-size: 16px;
}

.review-detail-card {
    background: #fff;
    border: 1px solid #e6e6e6;
    border-top: 0;
    border-radius: 0 0 22px 22px;
    padding: 34px;
    box-shadow: 0 14px 34px rgba(0,0,0,0.08);
}

.review-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 24px;
    margin-bottom: 30px;
}

.review-field-label {
    display: block;
    color: #667085;
    font-weight: 700;
    margin-bottom: 8px;
    font-size: 14px;
}

.review-field-box {
    min-height: 58px;
    background: #f9fafb;
    border-radius: 14px;
    padding: 14px 16px;
    display: flex;
    align-items: center;
    color: #111827;
    font-weight: 800;
}

.review-author-box {
    min-height: 70px;
    background: #f9fafb;
    border-radius: 14px;
    padding: 14px 16px;
    display: flex;
    align-items: center;
    gap: 12px;
}

.review-author-avatar {
    width: 44px;
    height: 44px;
    border-radius: 50%;
    background: #611232;
    color: #fff;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    font-size: 22px;
    flex-shrink: 0;
}

.review-author-name {
    color: #111827;
    font-weight: 800;
    margin-bottom: 2px;
}

.review-author-email {
    color: #667085;
    font-size: 13px;
}

.review-status {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    min-height: 40px;
    padding: 0 16px;
    border-radius: 12px;
    font-weight: 800;
}

.review-status.invited {
    background: #fff4cc;
    color: #8a6100;
}

.review-status.accepted {
    background: #e7f7ef;
    color: #157347;
}

.review-status.rejected {
    background: #fff1f2;
    color: #b42318;
}

.review-status.completed {
    background: #e8f6fb;
    color: #087990;
}

.review-status.expired {
    background: #f2f4f7;
    color: #667085;
}

.review-section {
    margin-top: 28px;
}

.review-section-title {
    color: #667085;
    font-weight: 800;
    margin-bottom: 10px;
}

.review-summary-box {
    background: #f9fafb;
    border-left: 5px solid #611232;
    border-radius: 14px;
    padding: 20px;
    color: #1f2937;
    line-height: 1.7;
}

.review-keywords {
    display: flex;
    flex-wrap: wrap;
    gap: 10px;
}

.review-keyword {
    display: inline-flex;
    align-items: center;
    gap: 7px;
    background: #f6eef1;
    color: #611232;
    border-radius: 12px;
    padding: 10px 14px;
    font-weight: 800;
}

.review-divider {
    border: 0;
    border-top: 1px solid #e6e6e6;
    margin: 32px 0 24px;
}

.review-actions {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 18px;
}

.review-btn {
    min-height: 58px;
    border-radius: 14px;
    border: none;
    font-size: 16px;
    font-weight: 900;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
    cursor: pointer;
}

.review-btn-accept {
    background: #157347;
    color: #fff;
}

.review-btn-accept:hover {
    background: #0f5c38;
    color: #fff;
}

.review-btn-reject {
    background: #dc3545;
    color: #fff;
}

.review-btn-reject:hover {
    background: #b42318;
    color: #fff;
}

.review-btn-gob {
    background: #611232;
    color: #fff;
}

.review-btn-gob:hover {
    background: #4a0e26;
    color: #fff;
}

.review-info-box {
    display: flex;
    gap: 14px;
    background: #eef6ff;
    border: 1px solid #b9dcff;
    border-radius: 14px;
    padding: 18px 20px;
    margin-top: 24px;
    color: #0b3b75;
}

.review-info-icon {
    font-size: 24px;
    color: #0b5ed7;
    line-height: 1;
}

.review-info-box strong {
    display: block;
    margin-bottom: 6px;
}

.review-info-box p {
    margin: 0;
    color: #0b3b75 !important;
    line-height: 1.6;
}

.review-alert-success {
    background: #edf7ef;
    border: 1px solid #c9e4cf;
    color: #2d5c36;
    border-radius: 14px;
    padding: 14px 18px;
    margin-bottom: 20px;
    font-weight: 700;
}

.review-alert-danger {
    background: #fff1f2;
    border: 1px solid #f2c7cc;
    color: #7a1c28;
    border-radius: 14px;
    padding: 14px 18px;
    margin-bottom: 20px;
    font-weight: 700;
}

.review-alert-info {
    background: #eef6ff;
    border: 1px solid #b9dcff;
    color: #0b3b75;
    border-radius: 14px;
    padding: 16px 18px;
    margin-top: 20px;
    font-weight: 700;
}

.review-expired-card {
    background: #fff;
    border: 1px solid #f2c7cc;
    border-radius: 22px;
    padding: 50px 30px;
    text-align: center;
    box-shadow: 0 14px 34px rgba(0,0,0,0.08);
}

.review-expired-icon {
    width: 78px;
    height: 78px;
    border-radius: 50%;
    background: #fff1f2;
    color: #dc3545;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    font-size: 42px;
    margin-bottom: 18px;
}

.review-expired-card h3 {
    color: #b42318;
    font-weight: 900;
    margin-bottom: 10px;
}

.review-expired-card p {
    color: #667085;
    margin-bottom: 22px;
}

.review-upload-card {
    background: #f9fafb;
    border: 1px solid #e6e6e6;
    border-radius: 18px;
    padding: 24px;
    margin-top: 24px;
}

.review-upload-card h4 {
    color: #1f2937;
    font-weight: 900;
    margin-bottom: 8px;
}

.review-upload-card p {
    color: #667085;
    margin-bottom: 18px;
}

.review-file-input {
    width: 100%;
    min-height: 52px;
    border: 1px solid #d0d5dd;
    border-radius: 14px;
    padding: 12px;
    background: #fff;
    margin-bottom: 16px;
}
/* =========================================================
   SEMANA 15 - DESCARGA DEL DOCUMENTO ORIGINAL
========================================================= */

.review-download-card {
    background: #ffffff;
    border: 1px solid #e6e6e6;
    border-left: 5px solid #611232;
    border-radius: 18px;
    padding: 24px;
    margin-top: 24px;
    margin-bottom: 24px;
    box-shadow: 0 10px 24px rgba(0,0,0,0.04);
}

.review-download-card h4 {
    color: #1f2937;
    font-weight: 900;
    margin-bottom: 8px;
}

.review-download-card p {
    color: #667085;
    margin-bottom: 18px;
    line-height: 1.6;
}

.review-download-meta {
    background: #f9fafb;
    border: 1px solid #edf0f2;
    border-radius: 14px;
    padding: 14px 16px;
    margin-bottom: 16px;
    color: #1f2937;
    font-weight: 800;
}

.review-download-meta small {
    display: block;
    color: #667085;
    font-size: 12px;
    font-weight: 800;
    margin-bottom: 4px;
    text-transform: uppercase;
    letter-spacing: .3px;
}

.review-btn-download {
    min-height: 58px;
    width: 100%;
    border-radius: 14px;
    background: #235B4E;
    color: #ffffff !important;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
    font-size: 16px;
    font-weight: 900;
    text-align: center;
    text-decoration: none !important;
    transition: all .2s ease;
}

.review-btn-download:hover {
    background: #13322E;
    color: #ffffff !important;
    transform: translateY(-1px);
}
/* =========================================================
   SEMANA 16 - REVISIÓN COMPLETADA
========================================================= */

.review-completed-card {
    background: #ffffff;
    border: 1px solid #d7e7dc;
    border-left: 5px solid #235B4E;
    border-radius: 18px;
    padding: 24px;
    margin-top: 24px;
    box-shadow: 0 10px 24px rgba(0,0,0,0.04);
}

.review-completed-header {
    display: flex;
    align-items: center;
    gap: 14px;
    margin-bottom: 14px;
}

.review-completed-icon {
    width: 48px;
    height: 48px;
    border-radius: 50%;
    background: #e9f5ef;
    color: #235B4E;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 24px;
    font-weight: 900;
    flex-shrink: 0;
}

.review-completed-card h4 {
    color: #1f2937;
    font-weight: 900;
    margin: 0 0 8px 0;
}

.review-completed-card p {
    color: #667085;
    line-height: 1.6;
    margin-bottom: 18px;
}

.review-completed-meta {
    background: #f9fafb;
    border: 1px solid #edf0f2;
    border-radius: 14px;
    padding: 14px 16px;
    color: #1f2937;
    font-weight: 800;
    margin-bottom: 12px;
}

.review-completed-meta small {
    display: block;
    color: #667085;
    font-size: 12px;
    font-weight: 800;
    margin-bottom: 4px;
    text-transform: uppercase;
    letter-spacing: .3px;
}

.review-status-completed {
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
}
@media (max-width: 768px) {
    .review-show-page {
        padding: 24px 14px 50px;
    }

    .review-hero {
        padding: 26px;
    }

    .review-hero h2 {
        font-size: 26px;
    }

    .review-detail-card {
        padding: 24px;
    }

    .review-grid {
        grid-template-columns: 1fr;
    }

    .review-actions {
        grid-template-columns: 1fr;
    }
}
</style>

<div class="gob-dashboard">

    {{-- SIDEBAR --}}
    @include('frontend.home.inc.sidebar')

    {{-- CONTENIDO --}}
    <div class="gob-main">

        <div class="review-show-page">

            <a href="{{ url('/review-invite/my') }}" class="review-back-link">
                <i class="las la-arrow-left"></i>
                Volver a invitaciones
            </a>

            {{-- EXPIRADA --}}
            @if(isset($expired) && $expired)

                <div class="review-expired-card">

                    <div class="review-expired-icon">
                        <i class="las la-clock"></i>
                    </div>

                    <h3>Invitación expirada</h3>

                    <p>
                        Este enlace ya no es válido o ha superado el tiempo permitido.
                    </p>

                    <a href="{{ route('frontend.home') }}" class="review-btn review-btn-gob" style="padding:0 24px; text-decoration:none;">
                        Volver al inicio
                    </a>

                </div>

            @else

                {{-- MENSAJES --}}
                @if(session('success'))
                    <div class="review-alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                @if(session('error'))
                    <div class="review-alert-danger">
                        {{ session('error') }}
                    </div>
                @endif

                {{-- HERO --}}
                <div class="review-hero">

                    <div class="review-hero-top">
                        <div class="review-hero-icon">
                            <i class="las la-file-alt"></i>
                        </div>

                        <div class="review-hero-id">
                            ID: {{ $invite->submission_id }}
                        </div>
                    </div>

                    <h2>
                        {{ $invite->submission->title ?? 'Documento sin título' }}
                    </h2>

                    <p>
                        Solicitud de revisión de documento institucional
                    </p>

                </div>

                {{-- DETALLE --}}
                <div class="review-detail-card">

                    <div class="review-grid">

                        <div>
                            <span class="review-field-label">
                                Estado
                            </span>

                            <div>
                                <span class="review-status
                                    @if($invite->status === 'invited') invited
                                    @elseif($invite->status === 'accepted') accepted
                                    @elseif($invite->status === 'rejected') rejected
                                    @elseif($invite->status === 'completed') completed
                                    @elseif($invite->status === 'expired') expired
                                    @else expired
                                    @endif
                                ">
                                    <i class="las la-clock"></i>

                                    @if($invite->status === 'invited')
                                        Invitado
                                    @elseif($invite->status === 'accepted')
                                        Aceptado
                                    @elseif($invite->status === 'rejected')
                                        Rechazado
                                    @elseif($invite->status === 'completed')
                                        Completado
                                    @elseif($invite->status === 'expired')
                                        Expirado
                                    @else
                                        {{ $invite->status }}
                                    @endif
                                </span>
                            </div>
                        </div>

                        <div>
                            <span class="review-field-label">
                                Fecha de envío
                            </span>

                            <div class="review-field-box">
                                <i class="las la-calendar" style="margin-right:8px; color:#667085;"></i>
                                {{ optional($invite->submission->created_at)->format('d/m/Y') ?? 'N/A' }}
                            </div>
                        </div>

                        <div>
                            <span class="review-field-label">
                                Autor
                            </span>

                            <div class="review-author-box">
                                <div class="review-author-avatar">
                                    <i class="las la-user"></i>
                                </div>

                                <div>
                                    <div class="review-author-name">
                                        {{ $invite->submission->author->name ?? 'N/A' }}
                                    </div>

                                    <div class="review-author-email">
                                        {{ $invite->submission->author->email ?? 'Sin correo' }}
                                    </div>
                                </div>
                            </div>
                        </div>

                     <div>
    <span class="review-field-label">
        ID del documento
    </span>

    <div class="review-field-box">
        #{{ $invite->submission_id }}
    </div>
</div>

<div>
    <span class="review-field-label">
        Fecha límite de revisión
    </span>

    <div class="review-field-box">
        <i class="las la-hourglass-half" style="margin-right:8px; color:#667085;"></i>

        @if($invite->review_due_at)
            {{ $invite->review_due_at->format('d/m/Y') }}
        @else
            Pendiente de aceptar
        @endif
    </div>
</div>

                    </div>

                    <div class="review-section">
                        <div class="review-section-title">
                            Resumen del documento
                        </div>

                        <div class="review-summary-box">
                            {{ $invite->submission->summary ?? 'Sin resumen disponible.' }}
                        </div>
                    </div>

                    <div class="review-section">
                        <div class="review-section-title">
                            Palabras clave
                        </div>

                        <div class="review-keywords">
                            <span class="review-keyword">
                                <i class="las la-tag"></i>
                                Revisión
                            </span>

                            <span class="review-keyword">
                                <i class="las la-tag"></i>
                                Documento institucional
                            </span>

                            <span class="review-keyword">
                                <i class="las la-tag"></i>
                                INIFAP
                            </span>
                        </div>
                    </div>

                    <hr class="review-divider">

                    {{-- INVITED --}}
                    @if($invite->status === 'invited')

                        <div class="review-actions">

                            <form method="POST"
                                  action="{{ url('/review-invite/'.$invite->invite_token_hash.'/accept') }}">
                                @csrf

                                <button type="submit" class="review-btn review-btn-accept" style="width:100%;">
                                    <i class="las la-check-circle"></i>
                                    Aceptar revisión
                                </button>
                            </form>

                            <form method="POST"
                                  action="{{ url('/review-invite/'.$invite->invite_token_hash.'/reject') }}">
                                @csrf

                                <button type="submit" class="review-btn review-btn-reject" style="width:100%;">
                                    <i class="las la-times-circle"></i>
                                    Rechazar invitación
                                </button>
                            </form>

                        </div>

                        <div class="review-info-box">
                            <div class="review-info-icon">
                                <i class="las la-info-circle"></i>
                            </div>

                            <div>
                                <strong>Información importante</strong>
                                <p>
                                    Al aceptar esta invitación, te comprometes a revisar el documento dentro del plazo establecido por el sistema.
                                    Después de aceptar, podrás continuar con la entrega de tu revisión en formato Word (.docx).
                                </p>
                            </div>
                        </div>

                                   {{-- ACCEPTED --}}
                    @elseif($invite->status === 'accepted')

                        <div class="review-alert-success">
                            Has aceptado esta revisión. Ya puedes descargar el documento original y subir tu archivo revisado.

                            @if($invite->review_due_at)
                                <br>
                                Fecha límite de entrega:
                                <strong>{{ $invite->review_due_at->format('d/m/Y') }}</strong>
                            @endif
                        </div>

                        @if($invite->review_due_at && now()->greaterThan($invite->review_due_at))
                            <div class="review-alert-danger">
                                La fecha límite para entregar esta revisión ya venció.
                            </div>
                        @endif

                        {{-- SEMANA 15 - DESCARGA DEL DOCUMENTO ORIGINAL --}}
                        <div class="review-download-card">

                            <h4>Documento original del Autor</h4>

                            <p>
                                Descarga el archivo original en formato Word (.docx) para realizar la revisión
                                con observaciones, comentarios o control de cambios.
                            </p>

                            <div class="review-download-meta">
                                <small>Documento asignado</small>
                                {{ $invite->submission->title ?? 'Documento sin título' }}
                            </div>

                            <a href="{{ url('/review-invite/'.$invite->invite_token_hash.'/download-original') }}"
                               class="review-btn-download">
                                <i class="las la-download"></i>
                                Descargar documento original (.docx)
                            </a>

                        </div>

                        {{-- SUBIDA DE REVISIÓN --}}
                        <div class="review-upload-card">

                            <h4>Subir revisión</h4>

                            <p>
                                Adjunta el archivo Word (.docx) con tus observaciones o control de cambios.
                            </p>

                            <form method="POST"
                                  action="{{ url('/review-invite/'.$invite->invite_token_hash.'/upload-review') }}"
                                  enctype="multipart/form-data">

                                @csrf

                                <input type="file"
                                       name="file"
                                       class="review-file-input"
                                       accept=".docx,application/vnd.openxmlformats-officedocument.wordprocessingml.document"
                                       required>

                                <button type="submit" class="review-btn review-btn-gob" style="width:100%;">
                                    <i class="las la-upload"></i>
                                    Subir revisión (.docx)
                                </button>

                            </form>

                        </div>

                  {{-- COMPLETED - SEMANA 16 --}}
@elseif($invite->status === 'completed')

    <div class="review-completed-card">

        <div class="review-completed-header">

            <div class="review-completed-icon">
                <i class="las la-check"></i>
            </div>

            <div>
                <h4>Revisión entregada correctamente</h4>

                <span class="review-status-completed">
                    <i class="las la-check-circle"></i>
                    Estado: Completado
                </span>
            </div>

        </div>

        <p>
            Tu archivo de revisión fue recibido por el sistema.
            El Secretario podrá consultar tu entrega y continuar con el flujo del documento.
        </p>

        <div class="review-completed-meta">
            <small>Documento revisado</small>
            {{ $invite->submission->title ?? 'Documento sin título' }}
        </div>

        @if($invite->review_uploaded_at)
            <div class="review-completed-meta">
                <small>Fecha de entrega</small>
                {{ $invite->review_uploaded_at->format('d/m/Y H:i') }}
            </div>
        @endif

        @if($invite->review_due_at)
            <div class="review-completed-meta">
                <small>Fecha límite original</small>
                {{ $invite->review_due_at->format('d/m/Y') }}
            </div>
        @endif

    </div>

                    {{-- REJECTED --}}
                    @elseif($invite->status === 'rejected')

                        <div class="review-alert-danger">
                            Has rechazado esta invitación de revisión.
                        </div>

                    @endif

                </div>

            @endif

        </div>

    </div>

</div>

@endsection