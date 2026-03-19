@extends("frontend.master")

@section("title", $user->name." - ".config('app.sitesettings')::first()->site_title)

@section("content")
@include("frontend.user.inc.author")

<section class="blog-author mt-30 gob-user-layout">
    <div class="container">
        <div class="row align-items-start">

            {{-- CONTENIDO PRINCIPAL --}}
            <div class="col-lg-9 gob-main-content">

                <div class="gob-upload-card">
                    <div class="gob-upload-card__inner">
                        <div>
                            <h4 class="gob-upload-card__title">
                                Sube tu primer documento para revisión :)
                            </h4>
                            <div class="gob-upload-card__text">
                                Word (.docx). (Semana 5: pantalla de envío)
                            </div>
                        </div>

                        <div>
                            <a href="{{ route('submissions.create') }}" class="gob-upload-btn">
                                Subir documento
                            </a>
                        </div>
                    </div>
                </div>

                @include("frontend.user.inc.post")
            </div>

            {{-- SIDEBAR DERECHO --}}
            <div class="col-lg-3 gob-sidebar-col">
                @include("frontend.user.inc.sidebar")
            </div>

        </div>
    </div>
</section>
@endsection