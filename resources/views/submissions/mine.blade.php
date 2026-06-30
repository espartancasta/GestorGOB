@extends('frontend.master')

@section('title', 'Convocatorias')

@push('styles')
    <link rel="stylesheet" href="{{ asset('assets/frontend/css/convocatorias.css') }}">
@endpush

@section('content')

<div class="gob-dashboard">
    @include('frontend.home.inc.sidebar')

    <div class="gob-main">
        <section class="convocatorias-page" aria-labelledby="convocatorias-title">
            <div class="convocatorias-heading">
                <span class="convocatorias-period">Periodo 2026</span>
                <h1 id="convocatorias-title">Convocatorias</h1>
                <p>Consulta las convocatorias disponibles para la presentación de propuestas académicas y proyectos.</p>
                <span class="convocatorias-rule" aria-hidden="true"></span>
            </div>

            <div class="convocatorias-grid">
                <article class="convocatoria-card">
                    <div class="convocatoria-media">
                        {{-- Placeholder temporal: reemplazar por public/assets/frontend/img/convocatorias/enero-abril.* --}}
                        <img src="{{ asset('assets/frontend/img/convocatorias/convocatoria-enero-abril.svg') }}" alt="Documentos académicos en revisión">
                        <span class="convocatoria-status status-closed">Cerrada</span>
                    </div>
                    <div class="convocatoria-body">
                        <span class="convocatoria-term">Primer Cuatrimestre</span>
                        <h2>Convocatoria Enero - Abril</h2>
                        <p>Periodo de recepción y evaluación de propuestas correspondientes al primer cuatrimestre del año.</p>
                        <div class="convocatoria-date">
                            <i class="las la-calendar" aria-hidden="true"></i>
                            <span>Enero - Abril 2025</span>
                        </div>
                        <a href="{{ asset('documents/convocatoria-blanca.pdf') }}" class="convocatoria-button" download>
                            Ver convocatoria
                            <i class="las la-angle-right" aria-hidden="true"></i>
                        </a>
                    </div>
                </article>

                <article class="convocatoria-card">
                    <div class="convocatoria-media">
                        {{-- Placeholder temporal: reemplazar por public/assets/frontend/img/convocatorias/mayo-agosto.* --}}
                        <img src="{{ asset('assets/frontend/img/convocatorias/convocatoria-mayo-agosto.svg') }}" alt="Personas revisando una propuesta académica">
                        <span class="convocatoria-status status-open">Abierta</span>
                    </div>
                    <div class="convocatoria-body">
                        <span class="convocatoria-term">Segundo Cuatrimestre</span>
                        <h2>Convocatoria Mayo - Agosto</h2>
                        <p>Periodo de recepción y evaluación de propuestas correspondientes al segundo cuatrimestre del año.</p>
                        <div class="convocatoria-date">
                            <i class="las la-calendar" aria-hidden="true"></i>
                            <span>Mayo - Agosto 2025</span>
                        </div>
                        <a href="{{ asset('documents/convocatoria-blanca.pdf') }}" class="convocatoria-button" download>
                            Ver convocatoria
                            <i class="las la-angle-right" aria-hidden="true"></i>
                        </a>
                    </div>
                </article>

                <article class="convocatoria-card">
                    <div class="convocatoria-media">
                        {{-- Placeholder temporal: reemplazar por public/assets/frontend/img/convocatorias/septiembre-diciembre.* --}}
                        <img src="{{ asset('assets/frontend/img/convocatorias/convocatoria-septiembre-diciembre.svg') }}" alt="Estudiantes consultando una convocatoria">
                        <span class="convocatoria-status status-soon">Próximamente</span>
                    </div>
                    <div class="convocatoria-body">
                        <span class="convocatoria-term">Tercer Cuatrimestre</span>
                        <h2>Convocatoria Septiembre - Diciembre</h2>
                        <p>Periodo de recepción y evaluación de propuestas correspondientes al tercer cuatrimestre del año.</p>
                        <div class="convocatoria-date">
                            <i class="las la-calendar" aria-hidden="true"></i>
                            <span>Septiembre - Diciembre 2025</span>
                        </div>
                        <a href="{{ asset('documents/convocatoria-blanca.pdf') }}" class="convocatoria-button" download>
                            Ver convocatoria
                            <i class="las la-angle-right" aria-hidden="true"></i>
                        </a>
                    </div>
                </article>
            </div>

            <aside class="convocatorias-help">
                <i class="las la-file-alt" aria-hidden="true"></i>
                <div>
                    <h2>¿Necesita ayuda?</h2>
                    <p>Para información adicional sobre las convocatorias comuníquese con la Dirección General de Investigación al correo <a href="mailto:convocatorias@institucion.gob.mx">convocatorias@institucion.gob.mx</a> o llame al <a href="tel:8000000000">800 000 0000</a>.</p>
                </div>
            </aside>
        </section>
    </div>
</div>

@endsection
