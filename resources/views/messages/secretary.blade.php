@extends('frontend.master')
@section('title', 'Mensajes')
@push('styles')
<link rel="stylesheet" href="{{ asset('assets/frontend/css/secretary-messages.css') }}">
@endpush
@section('content')
@php
    $decode = fn ($value) => html_entity_decode($value, ENT_QUOTES, 'UTF-8');
    $statusLabels = [
        'pending_assignment' => 'Pendiente de asignaci&oacute;n',
        'waiting_acceptance' => 'En espera de aceptaci&oacute;n',
        'in_review' => 'En revisi&oacute;n',
        'pending_correction' => 'Pendiente de correcci&oacute;n',
        'completed' => 'Revisi&oacute;n completada',
        'revision_completed' => 'Revisi&oacute;n completada',
        'approved' => 'Aprobado',
        'rejected' => 'No aprobado',
    ];
    $filters = [
        'all' => 'Todos',
        'recent' => 'Con mensajes recientes',
        'empty' => 'Sin mensajes',
        'pending' => 'Pendientes de respuesta',
    ];
@endphp
<div class="gob-dashboard secretary-messages-dashboard">
    @include('frontend.home.inc.sidebar')
    <main class="gob-main secretary-messages-main">
        <nav class="sm-breadcrumb" aria-label="Ruta de navegaci&oacute;n"><a href="{{ route('frontend.home') }}">Inicio</a><i class="las la-angle-right"></i><span>Mensajes</span></nav>
        <header class="sm-heading"><span class="sm-heading-icon"><i class="las la-comment-alt"></i></span><div><h1>Mensajes</h1><p>Consulta y da seguimiento a las conversaciones relacionadas con cada documento.</p></div></header>
        <section class="sm-filter-panel" aria-label="Buscar y filtrar conversaciones">
            <form method="GET" action="{{ route('messages.index') }}">
                <label class="sm-search"><span class="sr-only">Buscar conversaciones</span><i class="las la-search"></i><input type="search" name="q" value="{{ $search }}" placeholder="Buscar por t&iacute;tulo, autor o ID..."></label>
                <div class="sm-filter-list">
                    @foreach($filters as $key => $label)
                        <a href="{{ route('messages.index', array_filter(['q' => $search, 'filter' => $key === 'all' ? null : $key])) }}" class="{{ $filter === $key ? 'active' : '' }}">{{ $label }} <strong>{{ $filterCounts[$key] }}</strong></a>
                    @endforeach
                </div>
                <button type="submit" class="sr-only">Buscar</button>
            </form>
        </section>
        <div class="sm-list-summary"><span>{{ $submissions->total() }} {{ $submissions->total() === 1 ? 'conversaci&oacute;n' : 'conversaciones' }}</span><span>P&aacute;gina {{ $submissions->currentPage() }} de {{ $submissions->lastPage() }}</span></div>
        <section class="sm-conversation-list">
            @forelse($submissions as $submission)
                @php
                    $lastMessage = optional($submission->chatThread)->latestMessage;
                    $authorName = $submission->author->name ?? 'Autor no disponible';
                    $initials = collect(preg_split('/\s+/', trim($authorName)))->filter()->take(2)->map(fn ($part) => mb_strtoupper(mb_substr($part, 0, 1)))->implode('');
                    $state = $submission->status ?: 'pending_assignment';
                    $title = $submission->title ?: $submission->titulo_publicacion ?: 'Sin t&iacute;tulo';
                    $accent = match($state) { 'pending_correction' => 'correction', 'completed', 'revision_completed', 'approved' => 'completed', 'pending_assignment' => 'assignment', default => 'review' };
                @endphp
                <article class="sm-conversation sm-accent-{{ $accent }}">
                    <span class="sm-avatar" aria-hidden="true">{{ $initials ?: 'AU' }}</span>
                    <div class="sm-conversation-content">
                        <div class="sm-tags"><span class="sm-id">#{{ str_pad($submission->id, 3, '0', STR_PAD_LEFT) }}</span><span class="sm-status status-{{ $state }}"><i></i>{{ isset($statusLabels[$state]) ? $decode($statusLabels[$state]) : ucfirst(str_replace('_', ' ', $state)) }}</span></div>
                        <h2 title="{{ $title }}">{{ $title }}</h2>
                        <div class="sm-message-preview"><span>Autor: <strong>{{ $authorName }}</strong></span><i aria-hidden="true">&middot;</i><span><i class="las la-comments"></i> {{ $lastMessage ? \Illuminate\Support\Str::limit($lastMessage->body, 95) : $decode('A&uacute;n no hay mensajes en este documento.') }}</span></div>
                    </div>
                    <div class="sm-conversation-side">
                        @if($lastMessage)<time datetime="{{ $lastMessage->created_at->toIso8601String() }}"><i class="las la-clock"></i> {{ $lastMessage->created_at->locale('es')->calendar() }}</time>@endif
                        <a href="{{ route('submissions.chat.index', $submission) }}">Entrar al chat <i class="las la-arrow-right"></i></a>
                    </div>
                </article>
            @empty
                <div class="sm-empty"><i class="las la-comments"></i><h2>No se encontraron conversaciones</h2><p>No existen documentos que coincidan con los criterios seleccionados.</p><a href="{{ route('messages.index') }}">Limpiar filtros</a></div>
            @endforelse
        </section>
        @if($submissions->hasPages())
            <nav class="sm-pagination" aria-label="Paginaci&oacute;n de conversaciones">
                @if($submissions->onFirstPage())<span class="disabled"><i class="las la-angle-left"></i> Anterior</span>@else<a href="{{ $submissions->previousPageUrl() }}"><i class="las la-angle-left"></i> Anterior</a>@endif
                <div>@foreach($submissions->getUrlRange(1, $submissions->lastPage()) as $page => $url)<a href="{{ $url }}" class="{{ $page === $submissions->currentPage() ? 'active' : '' }}">{{ $page }}</a>@endforeach</div>
                @if($submissions->hasMorePages())<a href="{{ $submissions->nextPageUrl() }}">Siguiente <i class="las la-angle-right"></i></a>@else<span class="disabled">Siguiente <i class="las la-angle-right"></i></span>@endif
            </nav>
        @endif
    </main>
</div>
@endsection
