<div class="sidebar">

    <h5 class="mb-3">Panel del sistema</h5>

    <ul class="list-group">

        {{-- 🔥 REVISOR --}}
        @if(auth()->user()->role == 2)

            <li class="list-group-item">
                <a href="{{ route('review.invites') }}">
                    📩 Mis invitaciones
                </a>
            </li>

        @endif


        {{-- 🔥 AUTOR --}}
        @if(auth()->user()->role == 1)

            <li class="list-group-item">
                <a href="{{ route('submissions.create') }}">
                    📄 Subir documento
                </a>
            </li>

        @endif


        {{-- 🔥 SECRETARIO --}}
        @if(auth()->user()->role == 3)

            <li class="list-group-item">
                <a href="{{ route('submissions.index') }}">
                    📋 Documentos pendientes
                </a>
            </li>

        @endif

    </ul>

</div>