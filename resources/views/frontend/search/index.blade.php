@extends('frontend.master')

@section('title', 'Búsqueda de documentos')

@section('content')

@php
    $searchQuery = request('q');
@endphp

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

@endsection