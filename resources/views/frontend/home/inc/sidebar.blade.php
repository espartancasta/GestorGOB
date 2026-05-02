<div class="col-lg-3 oredoo-sidebar gob-home-sidebar-col">
    <div class="theiaStickySidebar">
        <div class="sidebar gob-home-sidebar-box">

            {{-- 🔥 PANEL DINÁMICO DEL SISTEMA --}}
            @auth
            <div class="card mb-3" style="border-radius:12px;">
                <div class="card-header" style="font-weight:700;">
                    Panel del sistema
                </div>

                <ul class="list-group list-group-flush">

                    {{-- 👤 AUTOR --}}
                    @if(auth()->user()->role == 1)
                        <li class="list-group-item">
                            <a href="{{ route('submissions.create') }}">
                                📄 Subir documento
                            </a>
                            <div style="font-size:12px;color:#666;">
                                Sube tu artículo o investigación a revisión
                            </div>
                        </li>
                    @endif

                    {{-- 🧑‍⚖️ REVISOR --}}
                    @if(auth()->user()->role == 2)
                        <li class="list-group-item">
                            <a href="#">
                                📥 Mis invitaciones
                            </a>
                        </li>
                    @endif

                    {{-- 🧑‍💼 SECRETARIO --}}
                    @if(auth()->user()->role == 3)
                        <li class="list-group-item">
                            <a href="{{ route('submissions.index') }}">
                                📋 Documentos pendientes
                            </a>
                        </li>
                    @endif

                    {{-- 🏛️ DICOVI --}}
                    @if(auth()->user()->role == 4)
                        <li class="list-group-item">
                            <a href="#">
                                🏁 Documentos finalizados
                            </a>
                        </li>
                    @endif

                </ul>
            </div>
            @endauth


            {{-- 🔽 SOLO dejamos búsqueda (opcional) --}}
            <x-frontend.sidebar-search/>

            {{-- ❌ ELIMINADO --}}
            {{-- <x-frontend.sidebar-category/> --}}
            {{-- <x-frontend.popular-posts/> --}}
            {{-- <x-frontend.sidebar-social/> --}}
            {{-- <x-frontend.tags/> --}}

        </div>
    </div>
</div>