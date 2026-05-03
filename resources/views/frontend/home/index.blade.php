@extends("frontend.master")

@section("content")

<div class="gob-dashboard">

    {{-- SIDEBAR --}}
    @include("frontend.home.inc.sidebar")

    {{-- CONTENIDO --}}
    <div class="gob-main">

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

    </div>

</div>

@endsection