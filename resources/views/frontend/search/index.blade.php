@extends('frontend.master')

@section('title', 'Búsqueda de documentos')

@section('content')

@php
    $searchQuery = request('q');
@endphp

@if($isAuthorTracking ?? false)

<style>
.tracking-page {
    background: #f8f7f6;
    color: #2d2628;
    padding-bottom: 48px;
}

.tracking-hero {
    max-width: 820px;
    margin: 0 0 40px;
    padding: 102px 0 0;
    background: transparent;
    border-bottom: 0;
    color: #4b5563;
    text-align: left;
}

.tracking-period {
    display: inline-flex;
    align-items: center;
    min-height: 26px;
    margin-bottom: 18px;
    padding: 5px 16px;
    border-radius: 4px;
    background: #611232;
    color: #ffffff;
    font-size: 12px;
    font-weight: 800;
    letter-spacing: 1px;
}

.tracking-seal {
    display: none;
    align-items: center;
    justify-content: center;
    width: 52px;
    height: 52px;
    margin-bottom: 14px;
    border: 2px solid rgba(255,255,255,.60);
    border-radius: 50%;
    color: #d4b05f;
    font-size: 28px;
}

.tracking-hero small {
    display: none;
    color: #6b7280;
    font-weight: 800;
    letter-spacing: 1px;
    margin-bottom: 28px;
}

.tracking-hero h1 {
    color: #4b5563;
    font-family: Georgia, "Times New Roman", serif;
    font-size: 38px;
    font-weight: 800;
    margin: 0 0 12px;
}

.tracking-hero p {
    max-width: 700px;
    margin: 0;
    color: #6b7280;
    font-size: 16px;
    font-weight: 500;
    line-height: 1.55;
}

.tracking-hero p::after {
    content: "";
    display: block;
    width: 220px;
    height: 2px;
    margin-top: 24px;
    background: linear-gradient(90deg, #a57f2c 0%, rgba(165, 127, 44, .18) 100%);
}

.tracking-wrap {
    display: grid;
    gap: 34px;
}

.tracking-summary,
.tracking-panel,
.tracking-reviewer-card {
    border: 1px solid #eadfe2;
    border-radius: 8px;
    background: #ffffff;
    box-shadow: 0 5px 16px rgba(17,24,39,.08);
}

.tracking-summary {
    display: flex;
    justify-content: space-between;
    gap: 24px;
    padding: 34px 32px;
    border-top: 4px solid #8a1538;
}

.tracking-eyebrow,
.tracking-label {
    display: block;
    color: #a57f2c;
    font-size: 12px;
    font-weight: 800;
    letter-spacing: 2px;
    text-transform: uppercase;
}

.tracking-summary h2 {
    margin: 8px 0 12px;
    color: #611232;
    font-family: Georgia, "Times New Roman", serif;
    font-size: 24px;
}

.tracking-meta {
    display: flex;
    flex-wrap: wrap;
    gap: 20px;
    color: #2d2628;
}

.tracking-meta div {
    border-right: 1px solid #e5d9dc;
    padding-right: 20px;
}

.tracking-meta div:last-child {
    border-right: 0;
}

.tracking-status-column {
    min-width: 260px;
    text-align: center;
}

.tracking-badge {
    display: inline-flex;
    align-items: center;
    gap: 9px;
    min-height: 30px;
    padding: 7px 16px;
    border-radius: 999px;
    font-size: 14px;
    font-weight: 800;
}

.tracking-badge::before {
    content: "";
    width: 8px;
    height: 8px;
    border-radius: 50%;
    background: currentColor;
}

.tracking-badge.is-reviewing {
    background: #fff4c2;
    color: #a16b00;
}

.tracking-badge.is-approved {
    background: #e3f8e6;
    color: #16803a;
}

.tracking-badge.is-observed {
    background: #ffe9cc;
    color: #c65300;
}

.tracking-badge.is-rejected {
    background: #ffe4e8;
    color: #b42318;
}

.tracking-section-title {
    margin: 0 0 18px;
    color: #611232;
    font-family: Georgia, "Times New Roman", serif;
    font-size: 24px;
}

.tracking-section-title::after {
    content: "";
    display: block;
    width: 68px;
    height: 2px;
    margin-top: 9px;
    background: #a57f2c;
}

.tracking-reviewers {
    display: grid;
    grid-template-columns: repeat(2, minmax(280px, 1fr));
    gap: 26px;
}

.tracking-reviewer-card {
    overflow: hidden;
}

.tracking-reviewer-head {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 15px 20px;
    background: #611232;
    color: #ffffff;
    font-weight: 800;
}

.tracking-reviewer-number {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 30px;
    height: 30px;
    border-radius: 50%;
    background: #c9a447;
    color: #ffffff;
    font-size: 12px;
}

.tracking-reviewer-body {
    padding: 22px 20px;
}

.tracking-reviewer-name {
    margin: 0 0 6px;
    color: #2d2628;
    font-size: 17px;
    font-weight: 700;
}

.tracking-reviewer-meta {
    margin: 0 0 18px;
    color: #6d625b;
}

.tracking-date-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 12px;
    margin-bottom: 18px;
}

.tracking-date-box {
    border-radius: 6px;
    background: #eee9e2;
    padding: 12px;
}

.tracking-date-box span {
    display: block;
    color: #7f746d;
    font-size: 12px;
    margin-bottom: 5px;
}

.tracking-status-block {
    margin: 12px 0 16px;
}

.tracking-action {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    width: 100%;
    min-height: 40px;
    border-radius: 5px;
    background: #611232;
    color: #ffffff !important;
    font-weight: 800;
    text-decoration: none !important;
}

.tracking-panel {
    padding: 26px 24px;
}

.tracking-doc-list {
    display: grid;
    gap: 14px;
}

.tracking-doc-item {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 16px;
    padding: 14px 0;
    border-bottom: 1px solid #eee4e7;
}

.tracking-doc-item:last-child {
    border-bottom: 0;
}

.tracking-doc-item strong {
    display: block;
    color: #111827;
}

.tracking-doc-item span {
    color: #6d625b;
    font-size: 13px;
}

.tracking-doc-actions {
    display: flex;
    gap: 10px;
}

.tracking-doc-actions a,
.tracking-secondary-action {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    min-height: 32px;
    padding: 0 14px;
    border-radius: 6px;
    background: #611232;
    color: #ffffff !important;
    font-size: 13px;
    font-weight: 800;
    text-decoration: none !important;
}

.tracking-muted {
    color: #6d625b;
    margin: 0;
}

.tracking-empty {
    padding: 34px;
    border: 1px dashed #d6c6ca;
    border-radius: 8px;
    background: #fff;
    color: #6d625b;
    text-align: center;
}

@media (max-width: 900px) {
    .tracking-hero {
        margin: 0 0 30px;
        padding-top: 72px;
    }

    .tracking-summary,
    .tracking-doc-item {
        flex-direction: column;
        align-items: flex-start;
    }

    .tracking-status-column {
        text-align: left;
    }

    .tracking-reviewers {
        grid-template-columns: 1fr;
    }
}
</style>

<div class="gob-dashboard">
    @include('frontend.home.inc.sidebar')

    <div class="gob-main">
        <section class="tracking-page">
            <header class="tracking-hero">
                <span class="tracking-period">Periodo 2026</span>
                <span class="tracking-seal"><i class="las la-crosshairs"></i></span>
                <small>GOBIERNO DE MÉXICO</small>
                <h1>Seguimiento de Evaluación</h1>
                <p>Consulte el estado de revisión de su propuesta, comuníquese con los revisores y dé seguimiento a las observaciones realizadas.</p>
            </header>

            <div class="tracking-wrap">
                @forelse($submissions as $submission)
                    @php
                        $reviewers = $submission->reviewers->values();
                        $reviewFiles = $submission->files->where('type', 'review_docx')->values();
                    @endphp

                    <article>
                        <div class="tracking-summary">
                            <div>
                                <span class="tracking-eyebrow">Propuesta de publicación</span>
                                <h2>{{ $submission->titulo_publicacion ?? $submission->title }}</h2>
                                <div class="tracking-meta">
                                    <div>
                                        <span class="tracking-label">Tipo</span>
                                        {{ $submission->tipo_publicacion ?? 'No registrado' }}
                                    </div>
                                    <div>
                                        <span class="tracking-label">Fecha de envío</span>
                                        {{ $submission->created_at ? $submission->created_at->format('d/m/Y') : 'Sin fecha' }}
                                    </div>
                                </div>
                            </div>

                            <div class="tracking-status-column">
                                <span class="tracking-label">Estado general</span>
                                <span class="tracking-badge {{ $submission->evaluationDecisionClass() }}">
                                    {{ $submission->evaluationDecisionLabel() }}
                                </span>
                            </div>
                        </div>

                        <h2 class="tracking-section-title" style="margin-top:34px;">Revisores asignados</h2>
                        <div class="tracking-reviewers">
                            @forelse($reviewers as $index => $reviewer)
                                <div class="tracking-reviewer-card">
                                    <div class="tracking-reviewer-head">
                                        <span class="tracking-reviewer-number">R{{ $index + 1 }}</span>
                                        Revisor {{ $index + 1 }}
                                    </div>
                                    <div class="tracking-reviewer-body">
                                        <p class="tracking-reviewer-name">{{ $reviewer->reviewer->name ?? 'Revisor asignado' }}</p>
                                        <p class="tracking-reviewer-meta">{{ $reviewer->reviewer->email ?? 'Sin correo registrado' }}</p>

                                        <div class="tracking-date-grid">
                                            <div class="tracking-date-box">
                                                <span>Asignación</span>
                                                {{ $reviewer->created_at ? $reviewer->created_at->format('d M Y') : 'N/A' }}
                                            </div>
                                            <div class="tracking-date-box">
                                                <span>Fecha límite</span>
                                                {{ $reviewer->review_due_at ? $reviewer->review_due_at->format('d M Y') : 'Pendiente' }}
                                            </div>
                                        </div>

                                        <div class="tracking-status-block">
                                            <span class="tracking-label">Estado</span>
                                            <span class="tracking-badge {{ $reviewer->reviewDecisionClass() }}">
                                                {{ $reviewer->reviewDecisionLabel() }}
                                            </span>
                                        </div>

                                        <a href="{{ route('submissions.chat.index', $submission) }}" class="tracking-action">
                                            <i class="las la-comment"></i>
                                            Ver conversación
                                        </a>
                                    </div>
                                </div>
                            @empty
                                <div class="tracking-empty">Aún no hay revisores asignados a esta propuesta.</div>
                            @endforelse
                        </div>

                        <div class="tracking-panel" style="margin-top:34px;">
                            <h2 class="tracking-section-title">Documentos de revisión</h2>
                            @if($reviewFiles->count() > 0)
                                <div class="tracking-doc-list">
                                    @foreach($reviewFiles as $reviewFile)
                                        <div class="tracking-doc-item">
                                            <div>
                                                <strong>{{ $reviewFile->original_name ?? 'Documento de revisión.docx' }}</strong>
                                                <span>{{ $reviewFile->created_at ? $reviewFile->created_at->format('d/m/Y H:i') : 'Sin fecha' }} · {{ $reviewFile->size ? round($reviewFile->size / 1024) . ' KB' : 'Sin tamaño' }}</span>
                                            </div>
                                            <div class="tracking-doc-actions">
                                                <a href="{{ route('submissions.show', $submission) }}">Ver</a>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <p class="tracking-muted">Aún no hay documentos de revisión disponibles.</p>
                            @endif
                        </div>

                        <div class="tracking-panel" style="margin-top:28px;">
                            <h2 class="tracking-section-title">Cargar versión corregida</h2>
                            @if($submission->status === 'pending_correction')
                                <p class="tracking-muted" style="margin-bottom:16px;">La propuesta recibió observaciones. Puede cargar una nueva versión corregida desde el expediente.</p>
                                <a href="{{ route('submissions.show', $submission) }}" class="tracking-secondary-action">Abrir carga de versión corregida</a>
                            @else
                                <p class="tracking-muted">La carga de versión corregida estará disponible cuando existan observaciones pendientes por atender.</p>
                            @endif
                        </div>
                    </article>
                @empty
                    <div class="tracking-empty">
                        Todavía no tienes propuestas en proceso de evaluación.
                    </div>
                @endforelse
            </div>
        </section>
    </div>
</div>

@else

<div class="gob-dashboard">

    {{-- SIDEBAR --}}
    @include('frontend.home.inc.sidebar')

    {{-- CONTENIDO --}}
    <div class="gob-main">

        <div class="gob-search-page">

            {{-- BUSCADOR GRANDE --}}
            <form method="GET"
                  action="{{ route('frontend.search') }}"
                  class="gob-search-main-form">

                <div class="gob-search-main-box">

                    <div class="gob-search-main-icon">
                        <i class="las la-search"></i>
                    </div>

                    <input type="text"
                           name="q"
                           value="{{ $searchQuery }}"
                           placeholder="Buscar documentos por título, autor o palabra clave..."
                           class="gob-search-main-input"
                           autocomplete="off">

                    <button type="submit"
                            class="gob-search-main-button">
                        Buscar
                    </button>

                </div>

            </form>

            {{-- ENCABEZADO RESULTADOS --}}
            <div class="gob-search-results-header">

                <div>
                    <h2>Resultados de búsqueda</h2>

                    @if($searchQuery)
                        <p>
                            {{ $submissions->total() }} documentos encontrados para
                            <strong>"{{ $searchQuery }}"</strong>
                        </p>
                    @else
                        <p>Ingresa un término para buscar documentos.</p>
                    @endif
                </div>

                <button type="button" class="gob-filter-btn">
                    <i class="las la-filter"></i>
                    Filtros
                </button>

            </div>

            {{-- RESULTADOS --}}
            @if($submissions->count() > 0)

                <div class="gob-search-results-grid">

                    @foreach($submissions as $submission)

                        <div class="gob-search-result-card">

                            <div class="gob-search-result-icon">
                                <i class="las la-file-alt"></i>
                            </div>

                            <div class="gob-search-result-body">

                                <h4>
                                    {{ $submission->title }}
                                </h4>

                                <p>
                                    {{ \Illuminate\Support\Str::limit($submission->summary ?? 'Sin resumen disponible.', 130) }}
                                </p>

                                <div class="gob-search-result-meta">
                                    <span>
                                        Autor: {{ $submission->author->name ?? 'N/A' }}
                                    </span>

                                    <span>
                                        {{ $submission->created_at->format('d/m/Y') }}
                                    </span>

                                    <span>
                                        Estado:
                                        @if($submission->status === 'pending_assignment')
                                            Pendiente de asignación
                                        @elseif($submission->status === 'waiting_acceptance')
                                            Esperando aceptación
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
                                    </span>
                                </div>

                                @auth
                                    @if(auth()->user()->role == 3)
                                        <div style="margin-top:14px;">
                                            <a href="{{ route('submissions.show', $submission->id) }}"
                                               class="gob-result-action">
                                                Ver documento
                                            </a>
                                        </div>
                                    @endif
                                @endauth

                            </div>

                        </div>

                    @endforeach

                </div>

                <div class="gob-search-pagination">
                    {{ $submissions->links('vendor.pagination.custom') }}
                </div>

            @else

                <div class="gob-search-empty">

                    <div class="gob-search-empty-icon">
                        <i class="las la-search"></i>
                    </div>

                    <h3>No se encontraron resultados</h3>

                    @if($searchQuery)
                        <p>Intenta con otros términos de búsqueda.</p>
                    @else
                        <p>Escribe una palabra clave para comenzar.</p>
                    @endif

                </div>

            @endif

        </div>

    </div>

</div>

@endif

@endsection
