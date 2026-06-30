@extends('frontend.master')

@section('title', 'Revisi&oacute;n completada')

@section('content')

<style>
.completed-page { min-height: calc(100vh - 140px); padding: 34px 0 48px; background: #f7f7f7; color: #1f2937; }
.completed-breadcrumb { display: flex; gap: 9px; margin-bottom: 10px; color: #7a5364; font-size: 13px; font-weight: 700; }
.completed-breadcrumb a { color: #7a5364 !important; text-decoration: none !important; }
.completed-heading { margin-bottom: 26px; }
.completed-heading h1 { margin: 0 0 10px; color: #611232 !important; font-size: 28px; font-weight: 900 !important; }
.completed-heading p { max-width: 760px; margin: 0; color: #6f5360 !important; font-size: 16px; line-height: 1.55; }
.completed-summary { display: flex; align-items: center; gap: 22px; margin-bottom: 34px; padding: 26px 30px; border: 1px solid #e8cfd8; border-radius: 16px; background: #fff; box-shadow: 0 7px 18px rgba(97,18,50,.08); }
.completed-summary-icon, .completed-document-icon { display: inline-flex; align-items: center; justify-content: center; flex: 0 0 auto; color: #611232; background: #faeef3; }
.completed-summary-icon { width: 48px; height: 48px; border-radius: 16px; background: #611232; color: #fff; font-size: 24px; }
.completed-summary-body h2 { margin: 0 0 6px; color: #111827 !important; font-size: 18px; font-weight: 900 !important; }
.completed-summary-body p { margin: 0 0 14px; color: #6f5360 !important; font-size: 14px; line-height: 1.45; }
.completed-summary-meta { display: flex; align-items: center; gap: 12px; flex-wrap: wrap; }
.completed-count { display: inline-flex; flex-direction: column; align-items: center; justify-content: center; min-width: 96px; min-height: 64px; border-radius: 10px; background: #faeef3; color: #611232; font-weight: 800; }
.completed-count strong { color: #611232; font-size: 24px; line-height: 1; }
.completed-count span { margin-top: 6px; color: #8a536a !important; font-size: 12px; }
.completed-role-badge, .completed-state-badge, .completed-result-badge, .completed-review-badge { display: inline-flex; align-items: center; gap: 6px; min-height: 28px; padding: 5px 13px; border-radius: 999px; font-size: 13px; font-weight: 800; white-space: nowrap; }
.completed-role-badge { background: #611232; color: #fff !important; }
.completed-list-head { display: flex; align-items: center; justify-content: space-between; gap: 16px; margin-bottom: 18px; }
.completed-list-head h2 { margin: 0; color: #111827 !important; font-size: 16px; font-weight: 900 !important; }
.completed-result-badge { background: #fff2f6; color: #8a1538 !important; }
.completed-list { display: grid; gap: 22px; }
.completed-card { position: relative; overflow: hidden; border: 1px solid #e8cfd8; border-radius: 16px; background: #fff; box-shadow: 0 8px 22px rgba(97,18,50,.08); }
.completed-card::before { content: ""; position: absolute; top: 0; right: 0; left: 0; height: 4px; background: #611232; }
.completed-card-inner { padding: 26px 24px 24px; }
.completed-document-head { display: flex; align-items: flex-start; justify-content: space-between; gap: 18px; margin-bottom: 20px; }
.completed-document-main { display: flex; gap: 16px; min-width: 0; }
.completed-document-icon { width: 50px; height: 50px; border-radius: 16px; font-size: 24px; }
.completed-document-title h3 { margin: 3px 0 4px; color: #111827 !important; font-size: 18px; font-weight: 900 !important; line-height: 1.25; }
.completed-document-title p { margin: 0; color: #7a5364 !important; font-size: 13px; }
.completed-state-badge { border: 1px solid #e3bbc8; background: #fff7fa; color: #8a1538 !important; }
.completed-description { margin: 0 0 18px; color: #745666 !important; font-size: 15px; line-height: 1.6; }
.completed-date { display: inline-flex; align-items: center; gap: 7px; margin-bottom: 20px; color: #7a5364 !important; font-size: 13px; }
.completed-date strong { color: #111827; }
.completed-review { padding: 18px 0 2px; border-top: 1px solid #eadde1; border-bottom: 1px solid #eadde1; }
.completed-review-title { display: flex; align-items: center; gap: 8px; margin-bottom: 14px; color: #7a5364; font-size: 12px; font-weight: 800; letter-spacing: .9px; text-transform: uppercase; }
.completed-review-row { display: flex; align-items: center; justify-content: space-between; gap: 16px; margin-bottom: 10px; }
.completed-review-row span { color: #111827 !important; font-size: 14px; }
.completed-review-row em { color: #7a5364; font-style: normal; }
.completed-review-badge.is-approved { background: #e5f7ee; color: #0a7a3e !important; }
.completed-review-badge.is-observed { background: #fff0dd; color: #bf5a00 !important; }
.completed-review-badge.is-rejected { background: #ffe8ec; color: #b42318 !important; }
.completed-review-badge.is-reviewing, .completed-review-badge.is-pending { background: #f1eef0; color: #6b5a62 !important; }
.completed-actions { display: flex; align-items: center; justify-content: space-between; gap: 14px; flex-wrap: wrap; margin-top: 18px; }
.completed-action-group { display: flex; gap: 12px; flex-wrap: wrap; }
.completed-btn { display: inline-flex; align-items: center; justify-content: center; gap: 8px; min-height: 40px; padding: 0 18px; border-radius: 10px; border: 1px solid transparent; font-size: 14px; font-weight: 900; text-decoration: none !important; }
.completed-btn-primary { background: #611232; color: #fff !important; box-shadow: 0 8px 16px rgba(97,18,50,.26); }
.completed-btn-secondary { border-color: #8a1538; background: #fff; color: #611232 !important; }
.completed-btn-muted { background: #eee8ec; color: #7a5364 !important; }
.completed-empty { padding: 34px 28px; border: 1px dashed #dec3cc; border-radius: 16px; background: #fff; text-align: center; box-shadow: 0 7px 18px rgba(97,18,50,.06); }
.completed-empty i { display: inline-flex; align-items: center; justify-content: center; width: 56px; height: 56px; margin-bottom: 14px; border-radius: 18px; background: #faeef3; color: #611232; font-size: 28px; }
.completed-empty h2 { margin: 0 0 8px; color: #111827 !important; font-size: 20px; font-weight: 900 !important; }
.completed-empty p { max-width: 560px; margin: 0 auto; color: #745666 !important; line-height: 1.55; }
@media (max-width: 760px) {
    .completed-page { padding-top: 24px; }
    .completed-summary, .completed-document-head, .completed-review-row, .completed-actions { align-items: flex-start; flex-direction: column; }
    .completed-state-badge { align-self: flex-start; }
    .completed-btn, .completed-action-group { width: 100%; }
}
</style>

<div class="gob-dashboard">
    @include('frontend.home.inc.sidebar')

    <div class="gob-main">
        <section class="completed-page" aria-labelledby="completed-title">
            <nav class="completed-breadcrumb" aria-label="Ruta de navegacion">
                <a href="{{ route('frontend.home') }}">Inicio</a>
                <span>/</span>
                <span>Revisi&oacute;n completada</span>
            </nav>

            <header class="completed-heading">
                <h1 id="completed-title">Revisi&oacute;n completada</h1>
                <p>Consulta los documentos que finalizaron el proceso de evaluaci&oacute;n y valida su env&iacute;o final para publicaci&oacute;n.</p>
            </header>

            <article class="completed-summary">
                <span class="completed-summary-icon" aria-hidden="true"><i class="las la-check-circle"></i></span>
                <div class="completed-summary-body">
                    <h2>Documentos listos para publicar</h2>
                    <p>Los documentos mostrados en esta secci&oacute;n ya concluyeron su revisi&oacute;n y est&aacute;n disponibles para validaci&oacute;n final.</p>
                    <div class="completed-summary-meta">
                        <span class="completed-count">
                            <strong>{{ $submissions->count() }}</strong>
                            <span>{{ $submissions->count() === 1 ? 'documento' : 'documentos' }}</span>
                        </span>
                        <span class="completed-role-badge">Autor</span>
                    </div>
                </div>
            </article>

            <div class="completed-list-head">
                <h2>Listado de documentos</h2>
                <span class="completed-result-badge">{{ $submissions->count() }} {{ $submissions->count() === 1 ? 'resultado' : 'resultados' }}</span>
            </div>

            @if($submissions->isNotEmpty())
                <div class="completed-list">
                    @foreach($submissions as $submission)
                        @php
                            $title = $submission->title ?? $submission->titulo_publicacion ?? 'Documento sin titulo';
                            $subtitle = $submission->convocatoria ?? $submission->call_name ?? 'Convocatoria Nacional de Investigacion 2026';
                            $description = $submission->description ?? $submission->summary ?? $submission->resumen ?? 'El documento concluyo el proceso de evaluacion por parte de los revisores asignados por el comite editorial.';
                            $finishedAt = $submission->completed_at ?? $submission->updated_at;
                            $reviewers = $submission->reviewers->values();
                        @endphp

                        <article class="completed-card">
                            <div class="completed-card-inner">
                                <div class="completed-document-head">
                                    <div class="completed-document-main">
                                        <span class="completed-document-icon" aria-hidden="true"><i class="las la-file-contract"></i></span>
                                        <div class="completed-document-title">
                                            <h3>{{ $title }}</h3>
                                            <p><i class="las la-book-open" aria-hidden="true"></i> {{ $subtitle }}</p>
                                        </div>
                                    </div>

                                    <span class="completed-state-badge"><i class="las la-check-circle" aria-hidden="true"></i> Revisi&oacute;n completada</span>
                                </div>

                                <p class="completed-description">{{ $description }}</p>

                                <span class="completed-date">
                                    <i class="las la-clock" aria-hidden="true"></i>
                                    Finalizado el
                                    <strong>{{ $finishedAt ? \Carbon\Carbon::parse($finishedAt)->format('d/m/Y') : 'Sin fecha' }}</strong>
                                </span>

                                <div class="completed-review">
                                    <div class="completed-review-title"><i class="las la-user-check" aria-hidden="true"></i> Dictamen de revisores</div>

                                    @forelse($reviewers as $index => $reviewer)
                                        <div class="completed-review-row">
                                            <span><strong>Revisor {{ $index + 1 }}:</strong> <em>{{ $reviewer->reviewer->name ?? 'Revisor asignado' }}</em></span>
                                            <span class="completed-review-badge {{ $reviewer->reviewDecisionClass() }}">{{ $reviewer->reviewDecisionLabel() }}</span>
                                        </div>
                                    @empty
                                        <div class="completed-review-row">
                                            <span>Sin dictamenes de revisores registrados.</span>
                                            <span class="completed-review-badge is-pending">Pendiente</span>
                                        </div>
                                    @endforelse
                                </div>

                                <div class="completed-actions">
                                    <div class="completed-action-group">
                                        <button type="button" class="completed-btn completed-btn-primary">
                                            <i class="las la-paper-plane" aria-hidden="true"></i>
                                            Validar env&iacute;o
                                        </button>

                                        <a href="{{ route('submissions.show', $submission) }}" class="completed-btn completed-btn-secondary">
                                            <i class="las la-folder-open" aria-hidden="true"></i>
                                            Ver expediente
                                        </a>
                                    </div>

                                    <a href="{{ route('submissions.chat.index', $submission) }}" class="completed-btn completed-btn-muted">
                                        <i class="las la-comment" aria-hidden="true"></i>
                                        Chat de seguimiento
                                    </a>
                                </div>
                            </div>
                        </article>
                    @endforeach
                </div>
            @else
                <div class="completed-empty">
                    <i class="las la-clipboard-check" aria-hidden="true"></i>
                    <h2>Sin documentos completados</h2>
                    <p>Cuando una propuesta finalice el proceso de revisi&oacute;n, aparecer&aacute; en esta secci&oacute;n para validar su env&iacute;o final.</p>
                </div>
            @endif
        </section>
    </div>
</div>

@endsection
