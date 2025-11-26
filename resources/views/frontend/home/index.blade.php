@extends("frontend.master")

@section("title", config('app.sitesettings')::first()->site_title . " - " . config('app.sitesettings')::first()->tagline)

@section("content")

{{-- Carrusel de destacados --}}
@include("frontend.home.inc.featuredpost")

{{-- Categorías --}}
@include("frontend.home.inc.category")

<section class="section-feature-1">
    <div class="container-fluid">
        <div class="row">

            {{-- ⭐ Sidebar a la IZQUIERDA --}}
            @include("frontend.home.inc.sidebar")

            {{-- ⭐ Artículos recientes a la DERECHA --}}
            @include("frontend.home.inc.recentpost")

        </div>
    </div>
</section>

@endsection
