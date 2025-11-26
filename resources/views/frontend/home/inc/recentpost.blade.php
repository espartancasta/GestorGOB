<div class="col-lg-8 oredoo-content">
    <div class="theiaStickySidebar">
        <div class="section-title">
            <h3>Artículos Recientes</h3>
            <p>Descubre los artículos más destacados sobre diferentes temas.</p>
        </div>
        @forelse ($recentposts as $recentpost)
        <div class="post-list post-list-style4">
            <div class="post-list-image">
                <a href="{{ route('frontend.post', $recentpost->slug) }}">
                    <img src="{{ asset('uploads/post/'.$recentpost->thumbnail) }}" alt="{{ $recentpost->title }}"/>
                </a>
            </div>
            <div class="post-list-content">
                <ul class="entry-meta">
                    <li class="entry-cat">
                        <a href="{{ route('frontend.category', $recentpost->category->slug) }}" class="category-style-1">
                            {{ $recentpost->category->title }}
                        </a>
                    </li>
                    <li class="post-date">
                        <span class="line"></span>{{ $recentpost->created_at->format('d F, Y') }}
                    </li>
                </ul>
                <h5 class="entry-title">
                    <a href="{{ route('frontend.post', $recentpost->slug) }}">
                        {{ $recentpost->title }}
                    </a>
                </h5>

                <div class="post-btn">
                    <a href="{{ route('frontend.post', $recentpost->slug) }}" class="btn-read-more">
                        Continuar Leyendo <i class="las la-long-arrow-alt-right"></i>
                    </a>
                </div>
            </div>
        </div>
        @empty
        <div>¡No se encontraron publicaciones!</div>
        @endforelse
        <div class="pagination">
            <div class="pagination-area">
                {{ $recentposts->links('vendor.pagination.custom') }}
            </div>
        </div>
    </div>
</div>
