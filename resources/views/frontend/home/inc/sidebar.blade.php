<div class="col-lg-3 oredoo-sidebar gob-home-sidebar-col">

    <div class="theiaStickySidebar">

        <div class="sidebar gob-home-sidebar-box"
             style="background:#fff; border-radius:12px; min-height:500px; overflow:hidden;">

            {{-- 🔥 HEADER --}}
            <div style="background:#611232; color:#fff; padding:14px 16px; font-weight:600;">
                Panel del sistema
            </div>

            {{-- 🔥 OPCIONES --}}
            <div style="padding:0;">

                {{-- REVISOR --}}
                @if(auth()->user()->role == 2)
                <div style="padding:14px 16px; border-bottom:1px solid #eee; background:#fafafa;">

                    <a href="{{ url('/review-invite/my') }}"
                       style="text-decoration:none; display:block;">

                        <div style="color:#611232; font-weight:600;">
                            📥 Mis invitaciones
                        </div>

                        <div style="font-size:13px; color:#777;">
                            Revisa solicitudes pendientes
                        </div>

                    </a>

                </div>
                @endif

                {{-- AUTOR --}}
                @if(auth()->user()->role == 1)
                <div style="padding:14px 16px; border-bottom:1px solid #eee;">
                    <a href="{{ route('submissions.create') }}" style="text-decoration:none;">
                        <div style="font-weight:600;">📄 Subir documento</div>
                        <div style="font-size:13px; color:#777;">
                            Enviar archivo a revisión
                        </div>
                    </a>
                </div>
                @endif

                {{-- SECRETARIO --}}
                @if(auth()->user()->role == 3)
                <div style="padding:14px 16px; border-bottom:1px solid #eee;">
                    <a href="{{ route('submissions.index') }}" style="text-decoration:none;">
                        <div style="font-weight:600;">📋 Documentos pendientes</div>
                        <div style="font-size:13px; color:#777;">
                            Asignar revisores
                        </div>
                    </a>
                </div>
                @endif

            </div>

            {{-- 🔍 BUSCADOR (como antes) --}}
            <div style="padding:16px;">
                <x-frontend.sidebar-search/>
            </div>

        </div>

    </div>

</div>