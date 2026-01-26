@extends("frontend.master")

@section("title", $user->name." - ".config('app.sitesettings')::first()->site_title)

@section("content")
@include("frontend.user.inc.author")

<section class="blog-author mt-30">
    <div class="container-fluid">
        <div class="row">

            {{-- Sidebar --}}
            <div class="col-lg-4 order-lg-1 order-2">
                @include("frontend.user.inc.sidebar")
            </div>

            {{-- Contenido --}}
            <div class="col-lg-8 order-lg-2 order-1">

                {{-- CTA (frontend) --}}
                <div class="text-center p-5">
                    <h4 class="mb-4">
                        Sube tu primer documento para revisión :)
                    </h4>

                    <button class="btn btn-primary btn-lg" type="button">
                        Subir documento
                    </button>
                </div>

                {{-- Posts del usuario (funcionalidad original) --}}
                @include("frontend.user.inc.post")

            </div>

        </div>
    </div>
</section>
@endsection
