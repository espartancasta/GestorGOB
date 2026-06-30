@extends('frontend.master')

@section('title', 'Revisiones asignadas')

@section('content')

<style>
.review-list { display: grid; gap: 18px; margin-top: 20px; }
.review-card {
    background: #fff;
    border: 1px solid rgba(0,0,0,.08);
    border-left: 5px solid #611232;
    border-radius: 12px;
    padding: 24px;
    box-shadow: 0 8px 24px rgba(0,0,0,.06);
}
.review-title { color: #611232; font-weight: 800; margin-bottom: 10px; }
.review-summary { color: #545454; margin-bottom: 16px; }
.review-meta {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
    gap: 12px;
    margin-bottom: 18px;
}
.review-meta small { color: #6c757d; display: block; }
.review-meta strong { color: #1f2937; display: block; }
.review-actions { display: flex; flex-wrap: wrap; gap: 10px; }
.btn-gob { background: #611232; color: #fff !important; }
.btn-gob:hover { background: #4a0e26; color: #fff !important; }
.btn-gob-green { background: #235B4E; color: #fff !important; }
.btn-gob-green:hover { background: #13322E; color: #fff !important; }
</style>

<div class="gob-dashboard">

    @include('frontend.home.inc.sidebar')

    <div class="gob-main">

        <div class="gob-header">
            <h2>Revisiones asignadas</h2>
            <p>Historial de documentos asignados para revisión.</p>
        </div>

        <div class="review-list">
            @forelse($invites as $invite)
                @php($submission = $invite->submission)

                <div class="review-card">
                    <h3 class="review-title">
                        {{ $submission->title ?? 'Sin título' }}
                    </h3>

                    <p class="review-summary">
                        {{ \Illuminate\Support\Str::limit($submission->summary ?? 'Sin resumen disponible.', 180) }}
                    </p>

                    <div class="review-meta">
                        <div>
                            <small>Estado de invitación</small>
                            <strong>{{ $invite->status }}</strong>
                        </div>

                        <div>
                            <small>Fecha de invitación</small>
                            <strong>{{ $invite->created_at ? $invite->created_at->format('d/m/Y') : 'N/A' }}</strong>
                        </div>

                        <div>
                            <small>Fecha límite</small>
                            <strong>{{ $invite->review_due_at ? $invite->review_due_at->format('d/m/Y') : 'Pendiente' }}</strong>
                        </div>

                        <div>
                            <small>Fecha de aceptación</small>
                            <strong>{{ $invite->accepted_at ? $invite->accepted_at->format('d/m/Y') : 'Pendiente' }}</strong>
                        </div>
                    </div>

                    <div class="review-actions">
                        <a href="{{ route('review.show', $invite->invite_token_hash) }}"
                           class="btn btn-gob">
                            Ver invitación
                        </a>

                        @if($submission)
                            <a href="{{ route('submissions.chat.index', $submission) }}"
                               class="btn btn-gob-green">
                                Chat
                            </a>
                        @endif
                    </div>
                </div>
            @empty
                <div class="review-card">
                    <p style="color:#6c757d; margin:0;">
                        No tienes revisiones asignadas actualmente.
                    </p>
                </div>
            @endforelse
        </div>

    </div>

</div>

@endsection
