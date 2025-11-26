<div class="widget">
    <div class="widget-title">
        <h5>Publicaciones Populares</h5> <!-- Título en español -->
    </div>
    <ul class="widget-popular-posts">
        @forelse ($popularposts as $popularpost)
            <li class="small-post">
                <div class="small-post-image">
                    <a href="{{ route('frontend.post', $popularpost->slug) }}" target="_blank">
                        <img src="{{ asset('uploads/post/'.$popularpost->thumbnail) }}" alt="{{ $popularpost->title }}"/>
                        <small class="nb">{{ $loop->iteration }}</small>
                    </a>
                </div>
                <div class="small-post-content">
                    <p>
                        <a href="{{ route('frontend.post', $popularpost->slug) }}" target="_blank">{{ $popularpost->title }}</a>
                    </p>
                    <small> <span class="slash"></span>{{ $popularpost->created_at->diffForHumans() }}</small>
                </div>
            </li>
        @empty
            <div>No se encontraron publicaciones.</div> <!-- Mensaje en español -->
        @endforelse
    </ul>
</div>
