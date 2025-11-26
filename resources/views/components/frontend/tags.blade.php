<div class="widget">
    <div class="widget-title">
        <h5>Etiquetas</h5>
    </div>
    <div class="widget-tags">
        <ul class="list-inline">
            @forelse ($tags as $tag)
            <li>
                <a href="{{ route('frontend.tag', $str::slug($tag->name)) }}" target="_blank">
                    #{{ $tag->name }}
                </a>
            </li>
            @empty
            <div>No se encontraron etiquetas.</div>
            @endforelse
        </ul>
    </div>
</div>
