@extends('frontend.master')

@section('title', 'Mensajes')

@section('content')

<div class="gob-dashboard">

    @include('frontend.home.inc.sidebar')

    <div class="gob-main">

        <div class="gob-header">
            <h2>Mensajes</h2>
            <p>Centro de conversaciones de seguimiento</p>
        </div>

        <div style="display:grid; gap:16px; margin-top:20px;">
            @forelse($submissions as $submission)
                @php
                    $lastMessage = optional($submission->chatThread)->messages
                        ? $submission->chatThread->messages->sortByDesc('created_at')->first()
                        : null;
                @endphp

                <div style="background:#fff; border:1px solid rgba(0,0,0,.08); border-left:5px solid #611232; border-radius:12px; padding:22px; box-shadow:0 8px 24px rgba(0,0,0,.06);">
                    <h3 style="color:#611232; font-weight:800; margin-bottom:8px;">
                        {{ $submission->title }}
                    </h3>

                    <p style="color:#545454; margin-bottom:10px;">
                        Estado: <strong>{{ $submission->status }}</strong>
                    </p>

                    <p style="color:#6c757d; margin-bottom:16px;">
                        @if($lastMessage)
                            Último mensaje: {{ \Illuminate\Support\Str::limit($lastMessage->body, 120) }}
                        @else
                            Aún no hay mensajes en este documento.
                        @endif
                    </p>

                    <a href="{{ route('submissions.chat.index', $submission) }}"
                       class="btn"
                       style="background:#611232; color:#fff;">
                        Entrar al chat
                    </a>
                </div>
            @empty
                <div style="background:#fff; border:1px solid rgba(0,0,0,.08); border-radius:12px; padding:28px; box-shadow:0 8px 24px rgba(0,0,0,.06);">
                    <p style="color:#6c757d; margin:0;">
                        No hay conversaciones disponibles para tu usuario.
                    </p>
                </div>
            @endforelse
        </div>

    </div>

</div>

@endsection
