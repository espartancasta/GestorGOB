@if ($socialmedia->count() > 0)
<div class="widget">
    <div class="widget-title">
        <h5>Conéctate con nosotros</h5> <!-- Título en español -->
    </div>
    <div class="widget-stay-connected">
        <div class="list">
            @foreach ($socialmedia as $media)
            <a href="{{ $media->link }}" target="_blank">
                <div class="item" style="background-color: {{ $media->color }}">
                    <i class="{{ $media->icon }} mr-2 text-white"></i>
                    <p>{{ $media->title }}</p> <!-- Mantener título de la red social -->
                </div>
            </a>
            @endforeach
        </div>
    </div>
</div>
@endif
