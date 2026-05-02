@extends('frontend.master')

@section('title', 'Enviar Documento - ' . config('app.sitesettings')::first()->site_title)

@section('content')

<section class="blog-author mt-30 mb-30">
<div class="container-fluid">
<div class="row">

    {{-- FORMULARIO --}}
    <div class="col-lg-9 gob-main-content">

        <div style="
        background:#fff;
        border:1px solid rgba(0,0,0,.08);
        border-radius:12px;
        padding:30px;
        box-shadow:0 8px 24px rgba(0,0,0,.06);
        margin-bottom:20px;
        ">

        <h3 style="font-weight:700;margin-bottom:10px;">
        Enviar documento para revisión
        </h3>

        <p style="color:#6c757d;margin-bottom:20px;">
        Complete los siguientes campos y adjunte su documento en formato Word (.docx)
        </p>

        {{-- ✅ SUCCESS BONITO --}}
        @if(session('success'))
            <div style="
                background:#e6ffed;
                border:1px solid #b7ebc6;
                color:#155724;
                padding:16px;
                border-radius:10px;
                margin-bottom:20px;
                display:flex;
                align-items:center;
                gap:10px;
                font-weight:600;
                animation:fadeIn 0.4s ease-in-out;
            ">
                <span style="font-size:20px;">✅</span>
                {{ session('success') }}
            </div>
        @endif

        {{-- ❌ ERROR --}}
        @if(session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        {{-- ⚠ VALIDACIONES --}}
        @if($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- 🔥 FORM --}}
        <form method="POST" action="{{ route('submissions.store') }}" enctype="multipart/form-data">
        @csrf

        {{-- TITULO --}}
        <div class="form-group mb-3">
            <label><b>Título del documento</b></label>
            <input 
                type="text"
                name="title"
                class="form-control"
                placeholder="Ej. Evaluación de suelos agrícolas"
                value="{{ old('title') }}"
                required
            >
        </div>

        {{-- RESUMEN --}}
        <div class="form-group mb-3">
            <label><b>Resumen</b></label>
            <textarea
                name="summary"
                rows="5"
                class="form-control"
                placeholder="Escriba una breve descripción del documento..."
                required
            >{{ old('summary') }}</textarea>
        </div>

        {{-- ARCHIVO --}}
        <div class="form-group mb-4">
            <label><b>Archivo del documento (.docx)</b></label>

            <input 
                type="file"
                name="file"
                class="form-control"
                accept=".docx"
                required
            >

            <small style="color:#6c757d;">
                Solo se permiten archivos Word (.docx)
            </small>
        </div>

        {{-- BOTÓN --}}
        <button 
            type="submit"
            style="
            background:#611232;
            border:1px solid #611232;
            color:#fff;
            padding:12px 28px;
            font-size:16px;
            font-weight:600;
            border-radius:10px;
            cursor:pointer;
            ">
            Enviar documento
        </button>

        </form>

        </div>

    </div>

    {{-- SIDEBAR --}}
    <div class="col-lg-3 gob-sidebar-col">
        {{-- si ya quitaste ese sidebar roto, puedes dejar vacío o poner otro --}}
    </div>

</div>
</div>
</section>

{{-- 🔥 ANIMACIÓN --}}
<style>
@keyframes fadeIn {
    from { opacity:0; transform:translateY(-10px); }
    to { opacity:1; transform:translateY(0); }
}
</style>

@endsection