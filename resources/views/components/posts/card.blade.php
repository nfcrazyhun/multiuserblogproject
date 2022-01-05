@props(['post'])

<article
    {{ $attributes->merge(['class' => 'transition-colors duration-300 hover:bg-gray-100 border border-black border-opacity-0 hover:border-opacity-5 rounded-xl']) }}>
    <div class="py-6 px-5 h-full flex flex-col">
        <div>
            <img src="{{ $post->thumbnail_url }}" alt="Blog Post illustration" class="rounded-xl">
        </div>

        <div class="mt-6 flex flex-col justify-between flex-1">
            <header>
                <div class="space-x-2">
                   <x-category-button :category="$post->category" />
                </div>

                <div class="mt-4">
                    <h1 class="text-3xl">
                        <a href="{{ route('user.posts.show', ['user' => $post->author->username, 'post' => $post]) }}">
                            {{ $post->title }}
                        </a>
                    </h1>

                    <span class="mt-2 block text-gray-400 text-xs">
                        Published <time>{{ $post->created_at->diffForHumans() }}</time>
                    </span>
                </div>
            </header>

            <div class="text-sm mt-4 space-y-4">
                {{ $post->excerpt }}
            </div>

            <footer class="mt-6 space-y-2">
                <div class="flex items-center text-sm">
                    <img
                        class="h-16 w-16 rounded-full"
                        src="{{ $post->author->avatar_url }}"
                        alt="Usernamee"
                    >
                    <div class="ml-3">
                        <h5 class="font-bold">
                            <a href="{{ route('user.posts.index', ['user' => $post->author]) }}">{{ $post->author->username }}</a>
                        </h5>
                    </div>
                </div>

                <div class="flex justify-end">
                    <a href="{{ route('user.posts.show', ['user' => $post->author->username, 'post' => $post]) }}"
                       class="transition-colors duration-300 text-xs font-semibold bg-gray-200 hover:bg-gray-300 rounded-full py-2 px-8"
                    >Read More</a>
                </div>
            </footer>
        </div>
    </div>
</article>