@extends("frontend.master")

@section("title", config('app.sitesettings')::first()->site_title . " - " . config('app.sitesettings')::first()->tagline)

@section("content")

@include("frontend.home.inc.featuredpost")
@include("frontend.home.inc.category")

<section class="section-feature-1">
    <div class="container">
       <div class="row">

    {{-- SIDEBAR IZQUIERDO 🔥 --}}
    @include("frontend.home.inc.sidebar")

    {{-- CONTENIDO PRINCIPAL --}}
    @include("frontend.home.inc.recentpost")

</div>
    </div>
</section>

@endsection