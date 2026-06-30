@extends('frontend.master')

@section('title', 'Nueva propuesta')

@push('styles')
    <link rel="stylesheet" href="{{ asset('assets/frontend/css/nueva-propuesta.css') }}">
@endpush

@section('content')

<div class="gob-dashboard">
    @include('frontend.home.inc.sidebar')

    <div class="gob-main">
        <section class="proposal-page" aria-labelledby="proposal-title">
            <header class="proposal-heading">
                <span class="proposal-period">Periodo 2026</span>
                <h1 id="proposal-title">Nueva propuesta</h1>
                <p>Capture la información de la publicación y adjunte el documento correspondiente para iniciar el proceso de evaluación.</p>
                <span class="proposal-rule" aria-hidden="true"></span>
            </header>

            @if(session('success'))
                <div class="proposal-alert proposal-alert-success">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="proposal-alert proposal-alert-danger">
                    {{ session('error') }}
                </div>
            @endif

            @if($errors->any())
                <div class="proposal-alert proposal-alert-danger">
                    <strong>Revise los siguientes campos:</strong>
                    <ul>
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form id="proposalForm"
                  class="proposal-card"
                  method="POST"
                  action="{{ route('submissions.store') }}"
                  enctype="multipart/form-data">
                @csrf

                <div class="proposal-card-body">
                    <div class="proposal-field">
                        <label for="titulo_publicacion">Título de la publicación <span>*</span></label>
                        <input type="text"
                               id="titulo_publicacion"
                               name="titulo_publicacion"
                               value="{{ old('titulo_publicacion') }}"
                               placeholder="Ej. Evaluación de suelos agrícolas mediante inteligencia artificial"
                               required>
                        @error('titulo_publicacion')
                            <p class="proposal-error">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="proposal-field">
                        <label for="tipo_publicacion">Tipo de publicación <span>*</span></label>
                        <div class="proposal-select-wrap">
                            <select id="tipo_publicacion" name="tipo_publicacion" required>
                                <option value="" disabled {{ old('tipo_publicacion') ? '' : 'selected' }}>Seleccione el tipo de publicación</option>
                                @foreach(['Artículo de investigación', 'Artículo de revisión', 'Artículo de reflexión', 'Reporte técnico', 'Otro'] as $tipo)
                                    <option value="{{ $tipo }}" {{ old('tipo_publicacion') === $tipo ? 'selected' : '' }}>{{ $tipo }}</option>
                                @endforeach
                            </select>
                            <i class="las la-angle-down" aria-hidden="true"></i>
                        </div>
                        @error('tipo_publicacion')
                            <p class="proposal-error">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="proposal-field">
                        <label for="resumen">Resumen <span>*</span></label>
                        <textarea id="resumen"
                                  name="resumen"
                                  placeholder="Describa brevemente el objetivo, metodología, resultados y conclusiones de la publicación."
                                  required>{{ old('resumen') }}</textarea>
                        <div class="proposal-counter"><span id="summaryCount">0</span> caracteres</div>
                        @error('resumen')
                            <p class="proposal-error">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="proposal-field">
                        <label for="keywordInput">Palabras clave</label>
                        <div class="proposal-tags-box">
                            <div id="keywordTags" class="proposal-tags"></div>
                            <div class="proposal-tags-row">
                                <input type="text"
                                       id="keywordInput"
                                       placeholder="Escriba una palabra clave y presione Enter o +">
                                <button type="button" id="addKeyword" class="proposal-add-tag">
                                    <i class="las la-plus" aria-hidden="true"></i>
                                    Agregar
                                </button>
                            </div>
                        </div>
                        <input type="hidden" id="palabras_clave" name="palabras_clave" value="{{ old('palabras_clave', '[]') }}">
                        @error('palabras_clave')
                            <p class="proposal-error">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="proposal-two-columns">
                        <div class="proposal-field">
                            <label for="autores">Nombre completo del autor o autores <span>*</span></label>
                            <input type="text"
                                   id="autores"
                                   name="autores"
                                   value="{{ old('autores') }}"
                                   placeholder="Ej. José Enrique Castañeda Nahuat; María López Hernández"
                                   required>
                            <small>Separe múltiples autores con punto y coma (;)</small>
                            @error('autores')
                                <p class="proposal-error">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="proposal-field">
                            <label for="institucion_adscripcion">Institución de adscripción <span>*</span></label>
                            <input type="text"
                                   id="institucion_adscripcion"
                                   name="institucion_adscripcion"
                                   value="{{ old('institucion_adscripcion') }}"
                                   placeholder="Universidad Tecnológica Metropolitana"
                                   required>
                            @error('institucion_adscripcion')
                                <p class="proposal-error">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="proposal-field">
                        <label for="archivo_documento">Documento adjunto <span>*</span></label>
                        <label id="dropZone" for="archivo_documento" class="proposal-dropzone">
                            <input type="file"
                                   id="archivo_documento"
                                   name="archivo_documento"
                                   accept=".docx,application/vnd.openxmlformats-officedocument.wordprocessingml.document"
                                   required>
                            <span class="proposal-upload-icon">
                                <i class="las la-upload" aria-hidden="true"></i>
                            </span>
                            <strong>Arrastre un archivo o haga clic para seleccionarlo</strong>
                            <span>Formato permitido: <b>.docx</b></span>
                            <em id="selectedFileName"></em>
                        </label>
                        <p id="fileFormatError" class="proposal-error" hidden>Solo se permite adjuntar un archivo .docx.</p>
                        @error('archivo_documento')
                            <p class="proposal-error">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <footer class="proposal-actions">
                    <span>* Campos obligatorios</span>
                    <div>
                        <button type="button" id="clearProposalForm" class="proposal-secondary-btn">
                            <i class="las la-trash-alt" aria-hidden="true"></i>
                            Limpiar formulario
                        </button>
                        <button type="submit" class="proposal-primary-btn">
                            <i class="las la-paper-plane" aria-hidden="true"></i>
                            Enviar propuesta
                        </button>
                    </div>
                </footer>
            </form>
        </section>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('proposalForm');
    const resumen = document.getElementById('resumen');
    const summaryCount = document.getElementById('summaryCount');
    const keywordInput = document.getElementById('keywordInput');
    const addKeyword = document.getElementById('addKeyword');
    const keywordTags = document.getElementById('keywordTags');
    const hiddenKeywords = document.getElementById('palabras_clave');
    const fileInput = document.getElementById('archivo_documento');
    const dropZone = document.getElementById('dropZone');
    const selectedFileName = document.getElementById('selectedFileName');
    const fileFormatError = document.getElementById('fileFormatError');
    const clearButton = document.getElementById('clearProposalForm');
    let keywords = [];

    try {
        keywords = JSON.parse(hiddenKeywords.value || '[]');
        if (!Array.isArray(keywords)) {
            keywords = [];
        }
    } catch (error) {
        keywords = [];
    }

    function updateCounter() {
        summaryCount.textContent = resumen.value.length;
    }

    function syncKeywords() {
        hiddenKeywords.value = JSON.stringify(keywords);
        keywordTags.innerHTML = '';

        keywords.forEach(function (keyword, index) {
            const tag = document.createElement('span');
            tag.className = 'proposal-tag';
            tag.innerHTML = keyword + ' <button type="button" aria-label="Eliminar ' + keyword + '">&times;</button>';
            tag.querySelector('button').addEventListener('click', function () {
                keywords.splice(index, 1);
                syncKeywords();
            });
            keywordTags.appendChild(tag);
        });
    }

    function addKeywordValue() {
        const value = keywordInput.value.trim();
        if (!value || keywords.includes(value)) {
            keywordInput.value = '';
            return;
        }

        keywords.push(value);
        keywordInput.value = '';
        syncKeywords();
    }

    function isDocx(file) {
        return file && file.name.toLowerCase().endsWith('.docx');
    }

    function showSelectedFile(file) {
        if (!file) {
            selectedFileName.textContent = '';
            fileFormatError.hidden = true;
            return;
        }

        if (!isDocx(file)) {
            fileInput.value = '';
            selectedFileName.textContent = '';
            fileFormatError.hidden = false;
            return;
        }

        selectedFileName.textContent = file.name;
        fileFormatError.hidden = true;
    }

    resumen.addEventListener('input', updateCounter);
    addKeyword.addEventListener('click', addKeywordValue);
    keywordInput.addEventListener('keydown', function (event) {
        if (event.key === 'Enter') {
            event.preventDefault();
            addKeywordValue();
        }
    });

    fileInput.addEventListener('change', function () {
        showSelectedFile(this.files[0]);
    });

    dropZone.addEventListener('dragover', function (event) {
        event.preventDefault();
        dropZone.classList.add('is-dragging');
    });

    dropZone.addEventListener('dragleave', function () {
        dropZone.classList.remove('is-dragging');
    });

    dropZone.addEventListener('drop', function (event) {
        event.preventDefault();
        dropZone.classList.remove('is-dragging');

        if (event.dataTransfer.files.length) {
            fileInput.files = event.dataTransfer.files;
            showSelectedFile(fileInput.files[0]);
        }
    });

    clearButton.addEventListener('click', function () {
        form.reset();
        keywords = [];
        syncKeywords();
        updateCounter();
        showSelectedFile(null);
    });

    form.addEventListener('submit', function (event) {
        if (fileInput.files.length && !isDocx(fileInput.files[0])) {
            event.preventDefault();
            fileFormatError.hidden = false;
        }
    });

    updateCounter();
    syncKeywords();
});
</script>

@endsection
