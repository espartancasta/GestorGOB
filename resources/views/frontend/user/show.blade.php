@extends('frontend.master')

@section('title', 'Perfil - ' . ($user->name ?? 'Usuario'))

@section('content')
<section class="mt-50 mb-50">
<div class="container-fluid">
<div class="row justify-content-center">

    <div class="col-lg-8">

        <div class="card shadow-sm" style="border-radius:16px;">

            <div class="card-body p-4">

                @php
                    $avatar = !empty($user->avatar)
                        ? asset($user->avatar)
                        : asset('assets/frontend/img/default-avatar.svg');
                @endphp

                {{-- 🔥 HEADER --}}
                <div class="d-flex align-items-center mb-4" style="gap:16px;">

                    <img src="{{ $avatar }}" alt="avatar"
                         style="width:90px;height:90px;border-radius:50%;object-fit:cover;border:1px solid #ddd;">

                    <div>

                        <h3 class="mb-1 fw-bold">
                            {{ $user->name ?? 'Usuario' }}
                        </h3>

                        <div class="text-muted">
                            &#64;{{ $user->username }}
                        </div>

                        <div class="text-muted">
                            {{ $user->email }}
                        </div>

                        <div class="mt-2">
                            <span class="badge bg-dark">
                                {{ $user->role_name ?? 'Sin rol' }}
                            </span>
                        </div>

                    </div>

                </div>

                <hr>

                {{-- 🔥 INFO GENERAL --}}
                <h5 class="fw-bold mb-3">Información General</h5>

                <div class="row">

                    <div class="col-md-6">
                        <p><strong>Perfil:</strong><br>
                            <span class="text-muted">{{ $user->profile ?? 'Sin información' }}</span>
                        </p>

                        <p><strong>Acerca de:</strong><br>
                            <span class="text-muted">{{ $user->about ?? 'Sin información' }}</span>
                        </p>

                        <p><strong>Empresa:</strong><br>
                            <span class="text-muted">{{ $user->empresa ?? 'No registrada' }}</span>
                        </p>

                        <p><strong>Sexo:</strong><br>
                            <span class="text-muted">{{ $user->sexo ?? 'No especificado' }}</span>
                        </p>
                    </div>

                    <div class="col-md-6">
                        <p><strong>Edad:</strong><br>
                            <span class="text-muted">{{ $user->edad ?? 'No especificada' }}</span>
                        </p>

                        <p><strong>CURP:</strong><br>
                            <span class="text-muted">{{ $user->curp ?? 'No registrada' }}</span>
                        </p>

                        <p><strong>RFC:</strong><br>
                            <span class="text-muted">{{ $user->rfc ?? 'No registrado' }}</span>
                        </p>

                        <p><strong>Registro:</strong><br>
                            <span class="text-muted">
                                {{ $user->created_at ? $user->created_at->format('d/m/Y') : '—' }}
                            </span>
                        </p>
                    </div>

                </div>

                <hr>

                {{-- 🔥 REDES --}}
                <h5 class="fw-bold mb-3">Redes Sociales</h5>

                <div class="row">

                    <div class="col-md-6">
                        <p><strong>Facebook:</strong><br>
                            <span class="text-muted">{{ $user->facebook ?? '—' }}</span>
                        </p>

                        <p><strong>Twitter:</strong><br>
                            <span class="text-muted">{{ $user->twitter ?? '—' }}</span>
                        </p>

                        <p><strong>Instagram:</strong><br>
                            <span class="text-muted">{{ $user->instagram ?? '—' }}</span>
                        </p>
                    </div>

                    <div class="col-md-6">
                        <p><strong>LinkedIn:</strong><br>
                            <span class="text-muted">{{ $user->linkedin ?? '—' }}</span>
                        </p>

                        <p><strong>YouTube:</strong><br>
                            <span class="text-muted">{{ $user->youtube ?? '—' }}</span>
                        </p>
                    </div>

                </div>

            </div>

        </div>

    </div>

</div>
</div>
</section>
@endsection