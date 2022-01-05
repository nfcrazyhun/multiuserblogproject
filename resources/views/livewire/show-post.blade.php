<div>
    <main class="mx-auto lg:my-10 space-y-6">
        <article class="max-w-4xl mx-auto lg:grid lg:grid-cols-12 gap-x-10">
            <div class="col-span-4 lg:text-center lg:pt-14 mb-10">
                <img src="{{ $post->thumbnail_url }}" alt="thumbnail" class="rounded-xl">

                <p class="mt-4 block text-gray-400 text-xs">
                    Published
                    <time>{{ $post->published_at->diffForHumans() }}</time>
                </p>

                <div class="flex items-center lg:justify-center text-sm mt-4">
                    <img
                        class="h-16 w-16 rounded-full"
                        src="{{ $post->author->avatar_url }}"
                        alt="Usernamee"
                    >

                    <div class="ml-3 text-left">
                        <h5 class="font-bold">
                            <a href="{{ route('user.posts.index', ['user' => $post->author]) }}">{{ $post->author->username }}</a>
                        </h5>
                    </div>
                </div>
            </div>

            <div class="col-span-8">
                <div class="hidden lg:flex justify-between mb-6">
                    <a href="{{ url()->previous(fallback:'/') }}"
                       class="transition-colors duration-300 relative inline-flex items-center text-lg hover:text-blue-500">
                        <svg width="22" height="22" viewBox="0 0 22 22" class="mr-2">
                            <g fill="none" fill-rule="evenodd">
                                <path stroke="#000" stroke-opacity=".012" stroke-width=".5" d="M21 1v20.16H.84V1z">
                                </path>
                                <path class="fill-current"
                                      d="M13.854 7.224l-3.847 3.856 3.847 3.856-1.184 1.184-5.04-5.04 5.04-5.04z">
                                </path>
                            </g>
                        </svg>

                        Back to Posts
                    </a>

                    <div class="space-x-2">
                        <x-category-button :category="$post->category"/>
                    </div>
                </div>

                <h1 class="font-bold text-3xl lg:text-4xl mb-10">
                    {{ $post->title }}
                </h1>

                <div class="space-y-4 lg:text-lg leading-loose prose ">
{{--                    {!! $post->content !!}--}}
                    {!! \Illuminate\Support\Str::of($post->content)->markdown() !!}

{{--<hr>--}}
{{--<p>Testing prone class</p>--}}
{{--<h1>Heading 1</h1>--}}
{{--<h2>Heading 2</h2>--}}
{{--<h3>Heading 3</h3>--}}
{{--<h4>Heading 4</h4>--}}
{{--<h5>Heading 5</h5>--}}
{{--<h6>Heading 6</h6>--}}

{{--<h2>An Unordered HTML List</h2>--}}
{{--<ul>--}}
{{--    <li>Coffee</li>--}}
{{--    <li>Tea</li>--}}
{{--    <li>Milk</li>--}}
{{--</ul>--}}

{{--<h2>An Ordered HTML List</h2>--}}
{{--<ol>--}}
{{--    <li>Coffee</li>--}}
{{--    <li>Tea</li>--}}
{{--    <li>Milk</li>--}}
{{--</ol>--}}

{{--    <a href="https://codepen.io/tigerpawz1/pen/mdBPXgg">Codepen super simple markdown editor link.</a>--}}
{{--    <a href="https://www.youtube.com/watch?v=wflzq5dFylE">And a youtube video for it.</a>--}}

{{--<blockquote cite="http://www.worldwildlife.org/who/index.html">--}}
{{--    For 50 years, WWF has been protecting the future of nature.--}}
{{--    The world's leading conservation organization,--}}
{{--    WWF works in 100 countries and is supported by--}}
{{--    1.2 million members in the United States and--}}
{{--    close to 5 million globally.--}}
{{--</blockquote>--}}

                </div>
            </div>
        </article>
    </main>
</div>
