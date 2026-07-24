@extends('frontend.master')
@section('title', 'Gestion de documentos')
@push('styles')
<link rel="stylesheet" href="{{ asset('assets/frontend/css/secretary-submissions.css') }}"/>
@endpush
@section('content')
@php
    $decode = fn ($value) => html_entity_decode($value, ENT_QUOTES, 'UTF-8');
    $labels = [
        'pending_assignment' => 'Pendiente de asignaci&oacute;n',
        'waiting_acceptance' => 'En espera de aceptaci&oacute;n',
        'in_review' => 'En revisi&oacute;n',
        'pending_correction' => 'Pendiente de correcci&oacute;n',
        'final_review' => 'Revisi&oacute;n final',
        'completed' => 'Revisi&oacute;n completada',
        'revision_completed' => 'Revisi&oacute;n completada',
        'approved' => 'Aprobado',
        'rejected' => 'No aprobado',
    ];
    $months = [1 => 'ene.', 'feb.', 'mar.', 'abr.', 'may.', 'jun.', 'jul.', 'ago.', 'sep.', 'oct.', 'nov.', 'dic.'];
@endphp
<div class="gob-dashboard secretary-dashboard">
    @include('frontend.home.inc.sidebar')
    <main class="gob-main secretary-main">
        <nav class="sec-breadcrumb" aria-label="Ruta de navegaci&oacute;n">
            <a href="{{ route('frontend.home') }}">Inicio</a><i class="las la-angle-right" aria-hidden="true"></i><span>Gesti&oacute;n de documentos</span>
        </nav>
        <header class="sec-heading">
            <h1>Gesti&oacute;n de documentos</h1>
            <p>Consulta, organiza y da seguimiento a las propuestas registradas en el sistema.</p>
        </header>
        <section class="sec-stats" aria-label="Resumen de documentos">
            @foreach([['file-alt','total','Total de documentos'],['hourglass','pending_assignment','Pendientes de asignaci&oacute;n'],['search','in_review','En revisi&oacute;n'],['pen','pending_correction','Pendientes de correcci&oacute;n']] as [$icon,$key,$label])
                <article class="sec-stat stat-{{ $key }}"><i class="las la-{{ $icon }}" aria-hidden="true"></i><div><strong>{{ (int) ($statistics->{$key} ?? 0) }}</strong><span>{{ $decode($label) }}</span></div></article>
            @endforeach
        </section>
        <section class="sec-filters" aria-label="B&uacute;squeda y filtros">
            <form method="GET" action="{{ route($listRoute) }}">
                <label><span class="sr-only">Buscar documentos</span><i class="las la-search" aria-hidden="true"></i><input type="search" name="q" value="{{ $search }}" placeholder="Buscar por t&iacute;tulo, autor o ID..."></label>
                <label><span class="sr-only">Filtrar por estado</span><i class="las la-filter" aria-hidden="true"></i><select name="status" onchange="this.form.submit()"><option value="">Todos los estados</option>@foreach($allowedStatuses as $option)<option value="{{ $option }}" @selected($status === $option)>{{ isset($labels[$option]) ? $decode($labels[$option]) : ucfirst(str_replace('_', ' ', $option)) }}</option>@endforeach</select></label>
                <button class="sr-only" type="submit">Buscar</button>
                <a href="{{ route($listRoute) }}"><i class="las la-times" aria-hidden="true"></i> Limpiar filtros</a>
            </form>
            <p>Mostrando <strong>{{ $submissions->count() }}</strong> de <strong>{{ $submissions->total() }}</strong> documentos</p>
        </section>
        <section class="sec-list" aria-live="polite">
            @forelse($submissions as $submission)
                @php($state = $submission->status ?: 'pending_assignment')
                <article class="sec-card">
                    <div class="sec-tags"><span class="sec-id">#{{ str_pad($submission->id, 3, '0', STR_PAD_LEFT) }}</span><span class="sec-status status-{{ $state }}"><i aria-hidden="true"></i>{{ isset($labels[$state]) ? $decode($labels[$state]) : ucfirst(str_replace('_', ' ', $state)) }}</span></div>
                    <h2>{{ $submission->title ?: $submission->titulo_publicacion ?: 'Sin t&iacute;tulo' }}</h2>
                    <div class="sec-meta">
                        <div><span>Autor</span><strong>{{ $submission->author->name ?? 'No disponible' }}</strong></div>
                        <div><span>Fecha de env&iacute;o</span><strong>{{ $submission->created_at ? sprintf('%02d %s %d', $submission->created_at->day, $months[$submission->created_at->month], $submission->created_at->year) : 'No disponible' }}</strong></div>
                        <div class="reviewers"><span>Revisores</span><strong>{{ min($submission->reviewers->count(), 2) }} de 2 asignados</strong></div>
                    </div>
                    <div class="sec-actions">
                        <a class="primary" href="{{ route('submissions.show', $submission) }}"><i class="las la-eye" aria-hidden="true"></i> Ver expediente</a>
                        @if($state === 'pending_assignment')<a href="{{ route('submissions.show', $submission) }}"><i class="las la-user-plus" aria-hidden="true"></i> Asignar revisores</a>@endif
                        <a href="{{ route('submissions.chat.index', $submission) }}"><i class="las la-comment" aria-hidden="true"></i> Abrir chat</a>
                    </div>
                </article>
            @empty
                <div class="sec-empty"><i class="las la-folder-open" aria-hidden="true"></i><h2>No se encontraron documentos</h2><p>No existen propuestas que coincidan con los criterios seleccionados.</p><a href="{{ route($listRoute) }}">Limpiar filtros</a></div>
            @endforelse
        </section>
        @if($submissions->hasPages())
            <nav class="sec-pagination" aria-label="Paginaci&oacute;n"><span>P&aacute;gina <strong>{{ $submissions->currentPage() }}</strong> de {{ $submissions->lastPage() }}</span><div>
                @if($submissions->onFirstPage())<span class="disabled"><i class="las la-angle-left"></i> Anterior</span>@else<a href="{{ $submissions->previousPageUrl() }}"><i class="las la-angle-left"></i> Anterior</a>@endif
                @foreach($submissions->getUrlRange(1, $submissions->lastPage()) as $page => $url)<a class="{{ $page === $submissions->currentPage() ? 'active' : '' }}" href="{{ $url }}" @if($page === $submissions->currentPage()) aria-current="page" @endif>{{ $page }}</a>@endforeach
                @if($submissions->hasMorePages())<a href="{{ $submissions->nextPageUrl() }}">Siguiente <i class="las la-angle-right"></i></a>@else<span class="disabled">Siguiente <i class="las la-angle-right"></i></span>@endif
            </div></nav>
        @endif
    </main>
</div>
@endsection
