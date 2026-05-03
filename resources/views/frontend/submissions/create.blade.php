@extends('frontend.master')

@section('title', 'Enviar Documento - ' . config('app.sitesettings')::first()->site_title)

@section('content')

<style>
/* =========================================================
   SUBIR DOCUMENTO - GESTORGOB / GOB STYLE
========================================================= */

.gob-submit-page {
    width: 100%;
}

.gob-submit-header {
    margin-bottom: 26px;
}

.gob-submit-header h2 {
    color: #1f2937;
    font-size: 32px;
    font-weight: 800;
    margin: 0 0 8px 0;
}

.gob-submit-header p {
    color: #667085;
    font-size: 16px;
    margin: 0;
}

.gob-submit-card {
    background: #fff;
    border: 1px solid #e6e6e6;
    border-radius: 18px;
    padding: 32px;
    box-shadow: 0 14px 35px rgba(0,0,0,0.06);
    max-width: 980px;
}

.gob-form-group {
    margin-bottom: 24px;
}

.gob-form-label {
    display: block;
    color: #111827;
    font-weight: 700;
    margin-bottom: 10px;
}

.gob-form-control {
    width: 100%;
    min-height: 52px;
    border: 1px solid #d0d5dd;
    border-radius: 14px;
    padding: 0 16px;
    color: #111827;
    background: #fff;
    outline: none;
    font-size: 15px;
}

.gob-form-control:focus {
    border-color: #611232;
    box-shadow: 0 0 0 4px rgba(97,18,50,0.10);
}

.gob-textarea {
    min-height: 150px;
    padding-top: 16px;
    resize: vertical;
}

.gob-upload-area {
    border: 2px dashed rgba(97,18,50,0.45);
    border-radius: 18px;
    background: #fbf7f8;
    min-height: 190px;
    display: flex;
    align-items: center;
    justify-content: center;
    text-align: center;
    padding: 28px;
    cursor: pointer;
    transition: all 0.2s ease;
}

.gob-upload-area:hover {
    border-color: #611232;
    background: #f6eef1;
}

.gob-upload-icon {
    width: 64px;
    height: 64px;
    border-radius: 50%;
    background: rgba(97,18,50,0.10);
    color: #611232;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    font-size: 34px;
    margin-bottom: 16px;
}

.gob-upload-title {
    color: #111827;
    font-weight: 800;
    margin-bottom: 6px;
}

.gob-upload-help {
    color: #667085;
    font-size: 14px;
    margin: 0;
}

.gob-file-name {
    margin-top: 12px;
    color: #611232;
    font-weight: 700;
    font-size: 14px;
}

.gob-info-box {
    display: flex;
    gap: 14px;
    background: #eef6ff;
    border: 1px solid #b9dcff;
    border-radius: 14px;
    padding: 18px 20px;
    margin-top: 26px;
    color: #0b3b75;
}

.gob-info-icon {
    font-size: 22px;
    line-height: 1;
    color: #0b5ed7;
}

.gob-info-box strong {
    display: block;
    margin-bottom: 6px;
}

.gob-info-box ul {
    margin: 0;
    padding-left: 18px;
}

.gob-info-box li {
    color: #0b3b75 !important;
    margin-bottom: 4px;
}

.gob-actions {
    display: flex;
    gap: 18px;
    margin-top: 34px;
}

.gob-submit-btn {
    flex: 1;
    min-height: 56px;
    border: none;
    border-radius: 14px;
    background: #611232;
    color: #fff;
    font-weight: 800;
    font-size: 16px;
    cursor: pointer;
}

.gob-submit-btn:hover {
    background: #4a0e26;
}

.gob-cancel-btn {
    min-width: 150px;
    min-height: 56px;
    border-radius: 14px;
    border: 1px solid #d0d5dd;
    background: #fff;
    color: #344054 !important;
    font-weight: 800;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    text-decoration: none !important;
}

.gob-cancel-btn:hover {
    background: #f9fafb;
    color: #611232 !important;
}

.gob-alert-success {
    background: #edf7ef;
    border: 1px solid #c9e4cf;
    color: #2d5c36;
    border-radius: 14px;
    padding: 14px 18px;
    margin-bottom: 20px;
    font-weight: 600;
    animation: fadeIn 0.35s ease-in-out;
}

.gob-alert-danger {
    background: #fff1f2;
    border: 1px solid #f2c7cc;
    color: #7a1c28;
    border-radius: 14px;
    padding: 14px 18px;
    margin-bottom: 20px;
}

.gob-alert-danger ul {
    margin: 0;
    padding-left: 20px;
}

.gob-error {
    color: #b42318;
    font-size: 13px;
    font-weight: 600;
    margin-top: 7px;
}

@keyframes fadeIn {
    from {
        opacity: 0;
        transform: translateY(-8px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

@media (max-width: 768px) {
    .gob-submit-card {
        padding: 22px;
    }

    .gob-submit-header h2 {
        font-size: 26px;
    }

    .gob-actions {
        flex-direction: column;
    }

    .gob-cancel-btn {
        width: 100%;
    }
}
</style>

<div class="gob-dashboard">

    {{-- SIDEBAR --}}
    @include('frontend.home.inc.sidebar')

    {{-- CONTENIDO --}}
    <div class="gob-main">

        <div class="gob-submit-page">

            <div class="gob-submit-header">
                <h2>Enviar documento para revisión</h2>
                <p>Complete los campos requeridos y adjunte su documento en formato Word (.docx).</p>
            </div>

            {{-- SUCCESS --}}
            @if(session('success'))
                <div class="gob-alert-success">
                    {{ session('success') }}
                </div>
            @endif

            {{-- ERROR --}}
            @if(session('error'))
                <div class="gob-alert-danger">
                    {{ session('error') }}
                </div>
            @endif

            {{-- VALIDACIONES --}}
            @if($errors->any())
                <div class="gob-alert-danger">
                    <strong>Revise los siguientes campos:</strong>
                    <ul>
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="gob-submit-card">

                <form method="POST"
                      action="{{ route('submissions.store') }}"
                      enctype="multipart/form-data">

                    @csrf

                    {{-- TÍTULO --}}
                    <div class="gob-form-group">
                        <label for="title" class="gob-form-label">
                            Título del documento
                        </label>

                        <input type="text"
                               id="title"
                               name="title"
                               class="gob-form-control"
                               placeholder="Ej. Evaluación de suelos agrícolas"
                               value="{{ old('title') }}"
                               required>

                        @error('title')
                            <div class="gob-error">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- RESUMEN --}}
                    <div class="gob-form-group">
                        <label for="summary" class="gob-form-label">
                            Resumen
                        </label>

                        <textarea id="summary"
                                  name="summary"
                                  class="gob-form-control gob-textarea"
                                  placeholder="Escriba una breve descripción del documento..."
                                  required>{{ old('summary') }}</textarea>

                        @error('summary')
                            <div class="gob-error">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- ARCHIVO --}}
                    <div class="gob-form-group">
                        <label class="gob-form-label">
                            Archivo del documento (.docx)
                        </label>

                        <label for="file" class="gob-upload-area">

                            <div>
                                <div class="gob-upload-icon">
                                    <i class="las la-upload"></i>
                                </div>

                                <div class="gob-upload-title">
                                    Haz clic para elegir un archivo
                                </div>

                                <p class="gob-upload-help">
                                    Solo se permiten archivos Word (.docx)
                                </p>

                                <div id="fileName" class="gob-file-name"></div>
                            </div>

                        </label>

                        <input type="file"
                               id="file"
                               name="file"
                               accept=".docx,application/vnd.openxmlformats-officedocument.wordprocessingml.document"
                               style="display:none;"
                               required>

                        @error('file')
                            <div class="gob-error">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- INFO --}}
                    <div class="gob-info-box">

                        <div class="gob-info-icon">
                            <i class="las la-info-circle"></i>
                        </div>

                        <div>
                            <strong>Antes de enviar</strong>
                            <ul>
                                <li>Verifica que todos los campos estén completos.</li>
                                <li>Asegúrate de que el archivo esté en formato .docx.</li>
                                <li>El documento será enviado al proceso de revisión institucional.</li>
                            </ul>
                        </div>

                    </div>

                    {{-- ACCIONES --}}
                    <div class="gob-actions">

                        <button type="submit" class="gob-submit-btn">
                            Enviar documento
                        </button>

                        <a href="{{ route('frontend.home') }}" class="gob-cancel-btn">
                            Cancelar
                        </a>

                    </div>

                </form>

            </div>

        </div>

    </div>

</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const input = document.getElementById('file');
    const fileName = document.getElementById('fileName');

    if (input && fileName) {
        input.addEventListener('change', function () {
            if (this.files && this.files.length > 0) {
                fileName.textContent = this.files[0].name;
            } else {
                fileName.textContent = '';
            }
        });
    }
});
</script>

@endsection