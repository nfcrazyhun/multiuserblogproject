<div>
    <x-slot name="header">{{ __('Home Page') }}</x-slot>

    <div>
        @if ($posts->count())
            <x-posts.grid :posts="$posts" />

            <!-- Pagination -->
            {{ $posts->links() }}
        @else
            <p class="text-center">No posts yet. Please check back later.</p>
        @endif
    </div>
</div>
