@extends('frontend.master')

@section('title', 'Perfil - ' . ($user->name ?? 'Usuario'))

@section('content')
<div class="container" style="padding-top:120px; padding-bottom:40px;">
    <div class="row">
        <div class="col-lg-8 mx-auto">

            <div class="card" style="border-radius:16px; border:1px solid #eee;">
                <div class="card-body" style="padding:24px;">

                    @php
                        $avatar = !empty($user->avatar)
                            ? asset($user->avatar)
                            : asset('assets/frontend/img/default-avatar.svg');
                    @endphp

                    {{-- HEADER --}}
                    <div class="d-flex align-items-center" style="gap:16px;">
                        <img src="{{ $avatar }}" alt="avatar"
                             style="width:88px;height:88px;border-radius:50%;object-fit:cover;border:1px solid #eee;">

                        <div>
                            <h3 style="margin:0; font-weight:800;">
                                {{ $user->name ?? 'Usuario' }}
                            </h3>

                            <div style="color:#666;">
                                @{{ $user->username }}
                            </div>

                            <div style="color:#666;">
                                {{ $user->email }}
                            </div>

                            <div style="margin-top:6px;">
                                <span class="badge bg-dark">
                                    {{ $user->role_name ?? 'Sin rol' }}
                                </span>
                            </div>
                        </div>
                    </div>

                    <hr>

                    {{-- INFORMACIÓN GENERAL --}}
                    <h5 style="font-weight:800;">Información General</h5>

                    <div class="row">
                        <div class="col-md-6">
                            <p><strong>Perfil:</strong> {{ $user->profile ?? 'Sin información' }}</p>
                            <p><strong>Acerca de:</strong> {{ $user->about ?? 'Sin información' }}</p>
                            <p><strong>Empresa:</strong> {{ $user->empresa ?? 'No registrada' }}</p>
                            <p><strong>Sexo:</strong> {{ $user->sexo ?? 'No especificado' }}</p>
                        </div>

                        <div class="col-md-6">
                            <p><strong>Edad:</strong> {{ $user->edad ?? 'No especificada' }}</p>
                            <p><strong>CURP:</strong> {{ $user->curp ?? 'No registrada' }}</p>
                            <p><strong>RFC:</strong> {{ $user->rfc ?? 'No registrado' }}</p>
                            <p><strong>Registro:</strong> {{ $user->created_at->format('d/m/Y') }}</p>
                        </div>
                    </div>

                    <hr>

                    {{-- REDES --}}
                    <h5 style="font-weight:800;">Redes Sociales</h5>

                    <ul style="margin:0; padding-left:18px;">
                        <li><strong>Facebook:</strong> {{ $user->facebook ?? '—' }}</li>
                        <li><strong>Twitter:</strong> {{ $user->twitter ?? '—' }}</li>
                        <li><strong>Instagram:</strong> {{ $user->instagram ?? '—' }}</li>
                        <li><strong>LinkedIn:</strong> {{ $user->linkedin ?? '—' }}</li>
                        <li><strong>YouTube:</strong> {{ $user->youtube ?? '—' }}</li>
                    </ul>

                </div>
            </div>

        </div>
    </div>
</div>
@endsection