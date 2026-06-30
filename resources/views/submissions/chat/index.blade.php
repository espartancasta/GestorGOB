@extends('frontend.master')

@section('title', 'Chat de seguimiento')

@section('content')

<style>
.chat-shell {
    background: #fff;
    border: 1px solid rgba(0,0,0,.08);
    border-radius: 12px;
    box-shadow: 0 8px 24px rgba(0,0,0,.06);
    margin-top: 20px;
    overflow: hidden;
}
.chat-document {
    border-bottom: 1px solid rgba(0,0,0,.08);
    padding: 18px 22px;
}
.chat-document strong { color: #611232; }
.chat-messages {
    display: flex;
    flex-direction: column;
    gap: 12px;
    max-height: 480px;
    overflow-y: auto;
    padding: 22px;
    background: #f8f9fa;
}
.chat-message {
    max-width: 76%;
    border-radius: 16px;
    padding: 12px 14px;
    background: #fff;
    border: 1px solid #e9ecef;
}
.chat-message.mine {
    align-self: flex-end;
    background: #611232;
    color: #fff;
}
.chat-message.theirs { align-self: flex-start; }
.chat-message-meta {
    display: block;
    font-size: 12px;
    font-weight: 700;
    margin-bottom: 6px;
    opacity: .78;
}
.chat-message-body {
    white-space: pre-wrap;
    overflow-wrap: anywhere;
}
.chat-form {
    display: grid;
    gap: 12px;
    padding: 18px 22px;
}
.chat-form textarea {
    min-height: 110px;
    resize: vertical;
    border: 1px solid #d0d5dd;
    border-radius: 12px;
    padding: 12px;
}
.btn-gob {
    background: #611232;
    color: #fff !important;
    border: none;
}
.btn-gob:hover { background: #4a0e26; }
</style>

<div class="gob-dashboard">

    @include('frontend.home.inc.sidebar')

    <div class="gob-main">

        <div class="gob-header">
            <h2>Chat de seguimiento</h2>
            <p>Documento: {{ $submission->title }}</p>
        </div>

        <div class="chat-shell">
            <div class="chat-document">
                <strong>{{ $submission->title }}</strong>
                <div style="color:#6c757d; margin-top:4px;">
                    Autor: {{ $submission->author->name ?? 'N/A' }} | Estado: {{ $submission->status }}
                </div>
            </div>

            <div id="chatMessages" class="chat-messages">
                @foreach($messages as $message)
                    <div class="chat-message {{ $message->user_id === auth()->id() ? 'mine' : 'theirs' }}">
                        <span class="chat-message-meta">
                            {{ $message->user->name ?? 'Usuario' }} · {{ $message->created_at ? $message->created_at->format('d/m/Y H:i') : '' }}
                        </span>
                        <div class="chat-message-body">{{ $message->body }}</div>
                    </div>
                @endforeach
            </div>

            <form id="chatForm" class="chat-form">
                @csrf
                <textarea name="body" id="chatBody" placeholder="Escribe un mensaje de seguimiento..." maxlength="2000" required></textarea>

                <div style="display:flex; flex-wrap:wrap; gap:10px; justify-content:space-between;">
                    <a href="{{ route('submissions.show', $submission) }}" class="btn btn-secondary">
                        Volver al expediente
                    </a>

                    <button type="submit" class="btn btn-gob">
                        Enviar
                    </button>
                </div>
            </form>
        </div>

    </div>

</div>

@endsection

@section('script')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const list = document.getElementById('chatMessages');
    const form = document.getElementById('chatForm');
    const body = document.getElementById('chatBody');
    const messagesUrl = @json(route('submissions.chat.messages', $submission));
    const storeUrl = @json(route('submissions.chat.store', $submission));
    const csrf = @json(csrf_token());

    function escapeHtml(value) {
        return value
            .replaceAll('&', '&amp;')
            .replaceAll('<', '&lt;')
            .replaceAll('>', '&gt;')
            .replaceAll('"', '&quot;')
            .replaceAll("'", '&#039;');
    }

    function render(messages) {
        list.innerHTML = messages.map(function (message) {
            const side = message.is_mine ? 'mine' : 'theirs';
            return `
                <div class="chat-message ${side}">
                    <span class="chat-message-meta">${escapeHtml(message.user_name)} · ${escapeHtml(message.created_at || '')}</span>
                    <div class="chat-message-body">${escapeHtml(message.body)}</div>
                </div>
            `;
        }).join('');
        list.scrollTop = list.scrollHeight;
    }

    function loadMessages() {
        fetch(messagesUrl, { headers: { 'Accept': 'application/json' } })
            .then(response => response.json())
            .then(data => render(data.messages || []));
    }

    form.addEventListener('submit', function (event) {
        event.preventDefault();

        const text = body.value.trim();
        if (!text) {
            return;
        }

        fetch(storeUrl, {
            method: 'POST',
            headers: {
                'Accept': 'application/json',
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrf
            },
            body: JSON.stringify({ body: text })
        })
            .then(response => response.json())
            .then(() => {
                body.value = '';
                loadMessages();
            });
    });

    list.scrollTop = list.scrollHeight;
    setInterval(loadMessages, 5000);
});
</script>
@endsection
