@extends("frontend.master")

@section("content")

<div class="gob-dashboard">

    {{-- SIDEBAR --}}
    @include("frontend.home.inc.sidebar")

    {{-- CONTENIDO --}}
    <div class="gob-main">

        {{-- =====================================================
            VISTA PARA AUTOR LOGUEADO
            Solo el Autor ve proyectos aprobados + Nuevo proyecto
        ====================================================== --}}
        @auth
            @if(auth()->user()->role == 1)

                <div class="gob-header">
                    <h2>Inicio</h2>
                    <p>Gestiona y explora proyectos de investigación aprobados</p>
                </div>

                {{-- DESPLEGABLE DE PROYECTOS --}}
                <details class="gob-projects-dropdown" open>

                    <summary class="gob-projects-summary">
                        <div>
                            <h3>Artículos / proyectos aprobados</h3>
                            <p>Consulta los documentos que ya finalizaron el proceso de revisión.</p>
                        </div>

                        <span class="gob-projects-summary-icon">
                            <i class="las la-angle-down"></i>
                        </span>
                    </summary>

                    <div class="gob-grid gob-approved-grid">

                        {{-- NUEVO PROYECTO --}}
                        <a href="{{ route('submissions.create') }}" class="gob-card gob-new-project-card">
                            <div class="gob-card-icon">
                                <i class="las la-plus-circle"></i>
                            </div>

                            <h4>Nuevo proyecto</h4>

                            <p>
                                Sube un nuevo documento de investigación para iniciar el flujo de revisión.
                            </p>

                            <div class="gob-card-footer">
                                <span>Autor</span>
                                <span>Crear</span>
                            </div>
                        </a>

                        {{-- PROYECTOS APROBADOS REALES --}}
                        @forelse(($approvedSubmissions ?? collect()) as $submission)

                            <div class="gob-card gob-approved-card">

                                <div class="gob-card-icon">
                                    <i class="las la-file-alt"></i>
                                </div>

                                <h4>{{ $submission->title }}</h4>

                                <p>
                                    {{ \Illuminate\Support\Str::limit($submission->summary, 110) }}
                                </p>

                                <div class="gob-card-footer">
                                    <span>
                                        {{ $submission->updated_at ? $submission->updated_at->diffForHumans() : 'Sin fecha' }}
                                    </span>

                                    <span class="gob-status-approved">
                                        Aprobado
                                    </span>
                                </div>

                            </div>

                        @empty

                            <div class="gob-card gob-empty-card">
                                <div class="gob-card-icon">
                                    <i class="las la-folder-open"></i>
                                </div>

                                <h4>Sin proyectos aprobados</h4>

                                <p>
                                    Todavía no hay documentos con estado completado. Cuando un artículo sea aprobado,
                                    aparecerá en esta sección.
                                </p>

                                <div class="gob-card-footer">
                                    <span>GestorGOB</span>
                                    <span>En espera</span>
                                </div>
                            </div>

                        @endforelse

                    </div>

                </details>

            @else

                {{-- =====================================================
                    VISTA PARA SECRETARIO / REVISOR / DICOVI
                    Se mantiene estilo principal normal
                ====================================================== --}}
                <div class="gob-header">
                    <h2>Inicio</h2>
                    <p>Gestiona y explora proyectos de investigación</p>
                </div>

                <div class="gob-grid">

                    @for ($i = 1; $i <= 6; $i++)
                        <div class="gob-card">
                            <div class="gob-card-icon">📄</div>

                            <h4>Proyecto de Investigación {{ $i }}</h4>

                            <p>
                                Descripción breve del proyecto de investigación
                                y sus principales hallazgos.
                            </p>

                            <div class="gob-card-footer">
                                <span>3 días atrás</span>
                                <span>⭐ 4.5</span>
                            </div>
                        </div>
                    @endfor

                </div>

            @endif
        @endauth


        {{-- =====================================================
            VISTA PÚBLICA / SIN INICIAR SESIÓN
            Queda como la segunda imagen original
        ====================================================== --}}
        @guest

            <div class="gob-header">
                <h2>Inicio</h2>
                <p>Gestiona y explora proyectos de investigación</p>
            </div>

            <div class="gob-grid">

                @for ($i = 1; $i <= 6; $i++)
                    <div class="gob-card">
                        <div class="gob-card-icon">📄</div>

                        <h4>Proyecto de Investigación {{ $i }}</h4>

                        <p>
                            Descripción breve del proyecto de investigación
                            y sus principales hallazgos.
                        </p>

                        <div class="gob-card-footer">
                            <span>3 días atrás</span>
                            <span>⭐ 4.5</span>
                        </div>
                    </div>
                @endfor

            </div>

        @endguest

    </div>

</div>

@endsection