@if(isset($posts) && $posts->count())
    @foreach($posts as $post)
        <div class="post-list mb-4">
            <div class="post-list-content">
                <h4 class="mb-2">
                    <a href="{{ route('frontend.post', $post->slug) }}">
                        {{ $post->title }}
                    </a>
                </h4>

                <div class="text-muted mb-3">
                    {{ $post->created_at->format('d/m/Y') }}
                </div>

                @if(!empty($post->excerpt))
                    <p class="mb-0">{{ \Illuminate\Support\Str::limit($post->excerpt, 180) }}</p>
                @endif
            </div>
        </div>
    @endforeach

    @if(method_exists($posts, 'links'))
        <div class="mt-4">
            {{ $posts->links('vendor.pagination.custom') }}
        </div>
    @endif
@endif
