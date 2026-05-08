@extends('frontend.master')

@section('title', 'Mis invitaciones')

@section('content')

<style>
/* =========================================================
   MIS INVITACIONES - REVISOR / GESTORGOB
========================================================= */

.review-page {
    width: 100%;
}

.review-header {
    margin-bottom: 28px;
}

.review-header h2 {
    font-size: 34px;
    font-weight: 800;
    color: #1f2937;
    margin: 0 0 8px 0;
}

.review-header p {
    color: #667085;
    font-size: 16px;
    margin: 0;
}

/* ESTADÍSTICAS */
.review-stats {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 22px;
    margin-bottom: 34px;
}

.review-stat-card {
    border-radius: 18px;
    padding: 24px;
    min-height: 140px;
    color: #fff;
    box-shadow: 0 14px 34px rgba(0,0,0,0.10);
    display: flex;
    align-items: center;
    justify-content: space-between;
}

.review-stat-card.primary {
    background: linear-gradient(135deg, #611232, #9F2241);
}

.review-stat-card.green {
    background: linear-gradient(135deg, #13322E, #235B4E);
}

.review-stat-card.gold {
    background: linear-gradient(135deg, #BC955C, #DDC9A3);
}

.review-stat-icon {
    width: 56px;
    height: 56px;
    border-radius: 16px;
    background: rgba(255,255,255,0.18);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 30px;
}

.review-stat-info {
    text-align: right;
}

.review-stat-number {
    font-size: 34px;
    font-weight: 900;
    line-height: 1;
}

.review-stat-label {
    margin-top: 8px;
    font-size: 15px;
    font-weight: 600;
}

/* LISTA */
.review-list {
    display: grid;
    gap: 24px;
}

.review-card {
    background: #fff;
    border: 1px solid #e6e6e6;
    border-radius: 20px;
    padding: 26px;
    box-shadow: 0 12px 30px rgba(0,0,0,0.06);
}

.review-card-top {
    display: flex;
    gap: 18px;
    align-items: flex-start;
}

.review-card-icon {
    width: 58px;
    height: 58px;
    border-radius: 16px;
    background: #f6eef1;
    color: #611232;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 30px;
    flex-shrink: 0;
}

.review-card-body {
    flex: 1;
}

.review-card-title-row {
    display: flex;
    justify-content: space-between;
    gap: 20px;
    align-items: flex-start;
}

.review-card h4 {
    font-size: 22px;
    line-height: 1.35;
    color: #1f2937;
    font-weight: 800;
    margin: 0 0 12px 0;
}

.review-summary {
    color: #667085;
    font-size: 15px;
    line-height: 1.6;
    margin: 0 0 20px 0;
}

.review-meta-box {
    background: #f9fafb;
    border-radius: 16px;
    padding: 18px;
    display: grid;
   grid-template-columns: repeat(4, 1fr);
    gap: 18px;
    margin-bottom: 18px;
}

.review-meta-item small {
    display: block;
    color: #667085;
    margin-bottom: 6px;
    font-size: 12px;
}

.review-meta-item strong {
    color: #1f2937;
    font-size: 14px;
}

/* BADGES */
.review-badge {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    min-height: 30px;
    padding: 0 12px;
    border-radius: 999px;
    font-size: 13px;
    font-weight: 800;
    white-space: nowrap;
}

.review-badge.invited {
    background: #fff4cc;
    color: #8a6100;
}

.review-badge.accepted {
    background: #e7f7ef;
    color: #157347;
}

.review-badge.rejected {
    background: #fff1f2;
    color: #b42318;
}

.review-badge.completed {
    background: #e8f6fb;
    color: #087990;
}

.review-badge.expired {
    background: #f2f4f7;
    color: #667085;
}

/* ACCIONES */
.review-actions {
    margin-top: 18px;
}

.btn-gob-review {
    width: 100%;
    min-height: 52px;
    border-radius: 14px;
    border: none;
    background: #611232;
    color: #fff !important;
    font-size: 16px;
    font-weight: 800;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    text-decoration: none !important;
    transition: 0.2s ease;
}

.btn-gob-review:hover {
    background: #4a0e26;
    color: #fff !important;
}

/* VACÍO */
.review-empty {
    background: #fff;
    border: 1px solid #e6e6e6;
    border-radius: 20px;
    padding: 50px 24px;
    text-align: center;
    box-shadow: 0 12px 30px rgba(0,0,0,0.05);
}

.review-empty-icon {
    width: 76px;
    height: 76px;
    border-radius: 50%;
    background: #f6eef1;
    color: #611232;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    font-size: 38px;
    margin-bottom: 18px;
}

.review-empty h4 {
    color: #1f2937;
    font-weight: 800;
    margin-bottom: 8px;
}

.review-empty p {
    color: #667085;
    margin: 0;
}

/* RESPONSIVE */
@media (max-width: 992px) {
    .review-stats {
        grid-template-columns: 1fr;
    }

    .review-meta-box {
        grid-template-columns: 1fr;
    }

    .review-card-title-row {
        flex-direction: column;
    }
}
</style>

<div class="gob-dashboard">

    {{-- SIDEBAR --}}
    @include('frontend.home.inc.sidebar')

    {{-- CONTENIDO --}}
    <div class="gob-main">

        @php
            $totalInvites = $invites->count();
            $pendingInvites = $invites->where('status', 'invited')->count();
            $acceptedInvites = $invites->where('status', 'accepted')->count();
            $completedInvites = $invites->where('status', 'completed')->count();
        @endphp

        <div class="review-page">

            {{-- HEADER --}}
            <div class="review-header">
                <h2>Invitaciones de revisión</h2>
                <p>
                    Tienes {{ $pendingInvites }} solicitudes de revisión pendientes.
                </p>
            </div>

            {{-- STATS --}}
            <div class="review-stats">

                <div class="review-stat-card primary">
                    <div class="review-stat-icon">
                        <i class="las la-envelope"></i>
                    </div>

                    <div class="review-stat-info">
                        <div class="review-stat-number">
                            {{ $pendingInvites }}
                        </div>
                        <div class="review-stat-label">
                            Invitaciones pendientes
                        </div>
                    </div>
                </div>

                <div class="review-stat-card green">
                    <div class="review-stat-icon">
                        <i class="las la-check-circle"></i>
                    </div>

                    <div class="review-stat-info">
                        <div class="review-stat-number">
                            {{ $acceptedInvites }}
                        </div>
                        <div class="review-stat-label">
                            Revisiones aceptadas
                        </div>
                    </div>
                </div>

                <div class="review-stat-card gold">
                    <div class="review-stat-icon">
                        <i class="las la-file-alt"></i>
                    </div>

                    <div class="review-stat-info">
                        <div class="review-stat-number">
                            {{ $totalInvites }}
                        </div>
                        <div class="review-stat-label">
                            Total asignadas
                        </div>
                    </div>
                </div>

            </div>

            {{-- LISTA --}}
            <div class="review-list">

                @forelse($invites as $invite)

                    <div class="review-card">

                        <div class="review-card-top">

                            <div class="review-card-icon">
                                <i class="las la-file-alt"></i>
                            </div>

                            <div class="review-card-body">

                                <div class="review-card-title-row">

                                    <div>
                                        <h4>
                                            {{ $invite->submission->title ?? 'Sin título' }}
                                        </h4>

                                        <p class="review-summary">
                                            {{ \Illuminate\Support\Str::limit($invite->submission->summary ?? 'Sin resumen disponible.', 170) }}
                                        </p>
                                    </div>

                                    <span class="review-badge
                                        @if($invite->status === 'invited') invited
                                        @elseif($invite->status === 'accepted') accepted
                                        @elseif($invite->status === 'rejected') rejected
                                        @elseif($invite->status === 'completed') completed
                                        @elseif($invite->status === 'expired') expired
                                        @else expired
                                        @endif
                                    ">
                                        @if($invite->status === 'invited')
                                            Pendiente
                                        @elseif($invite->status === 'accepted')
                                            Aceptada
                                        @elseif($invite->status === 'rejected')
                                            Rechazada
                                        @elseif($invite->status === 'completed')
                                            Completada
                                        @elseif($invite->status === 'expired')
                                            Expirada
                                        @else
                                            {{ $invite->status }}
                                        @endif
                                    </span>

                                </div>

                             <div class="review-meta-box">

    <div class="review-meta-item">
        <small>Autor</small>
        <strong>
            {{ $invite->submission->author->name ?? 'N/A' }}
        </strong>
    </div>

    <div class="review-meta-item">
        <small>Fecha de envío</small>
        <strong>
            {{ optional($invite->submission->created_at)->format('d/m/Y') ?? 'N/A' }}
        </strong>
    </div>

    <div class="review-meta-item">
        <small>Fecha límite</small>
        <strong>
            @if($invite->review_due_at)
                {{ $invite->review_due_at->format('d/m/Y') }}
            @else
                Pendiente
            @endif
        </strong>
    </div>

    <div class="review-meta-item">
        <small>ID documento</small>
        <strong>
            #{{ $invite->submission->id ?? 'N/A' }}
        </strong>
    </div>

</div>

                                <div class="review-actions">
                                    <a href="{{ url('/review-invite/'.$invite->invite_token_hash) }}"
                                       class="btn-gob-review">
                                        Ver detalles y responder
                                    </a>
                                </div>

                            </div>

                        </div>

                    </div>

                @empty

                    <div class="review-empty">

                        <div class="review-empty-icon">
                            <i class="las la-envelope-open"></i>
                        </div>

                        <h4>No tienes invitaciones aún</h4>

                        <p>
                            Cuando el Secretario te asigne un documento para revisión,
                            aparecerá en esta sección.
                        </p>

                    </div>

                @endforelse

            </div>

        </div>

    </div>

</div>

@endsection