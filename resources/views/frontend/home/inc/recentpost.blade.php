<div class="col-lg-9" style="padding-left:30px;">

    <div class="theiaStickySidebar">

        <div class="section-title" style="margin-bottom:20px;">
            <h3 style="font-weight:700;">Artículos recientes</h3>
            <p style="color:#777;">Consulta publicaciones disponibles en el sistema.</p>
        </div>

        @forelse ($recentposts as $recentpost)
            <div class="post-list post-list-style4" style="margin-bottom:20px;">
                <div class="post-list-image">
                    <a href="{{ route('frontend.post', $recentpost->slug) }}">
                        <img src="{{ asset('uploads/post/'.$recentpost->thumbnail) }}" alt="{{ $recentpost->title }}"/>
                    </a>
                </div>

                <div class="post-list-content">

                    <ul class="entry-meta">
                        <li class="entry-cat">
                            <a href="{{ route('frontend.category', $recentpost->category->slug) }}">
                                {{ $recentpost->category->title }}
                            </a>
                        </li>
                        <li class="post-date">
                            {{ $recentpost->created_at->format('d F, Y') }}
                        </li>
                    </ul>

                    <h5 class="entry-title">
                        <a href="{{ route('frontend.post', $recentpost->slug) }}">
                            {{ $recentpost->title }}
                        </a>
                    </h5>

                    <a href="{{ route('frontend.post', $recentpost->slug) }}" class="btn btn-sm btn-outline-primary">
                        Ver más
                    </a>

                </div>
            </div>

        @empty
            <div style="
                background:#fff;
                padding:20px;
                border-radius:10px;
                border:1px solid #eee;
            ">
                Actualmente no hay publicaciones disponibles.
            </div>
        @endforelse

        <div class="pagination mt-3">
            {{ $recentposts->links('vendor.pagination.custom') }}
        </div>

    </div>

</div>