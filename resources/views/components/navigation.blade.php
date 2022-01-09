<nav x-data="{ open: false }" class="bg-gray-800">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-16">
            <div class="flex items-center">
                <!-- Logo -->
                <div class="flex-shrink-0">
                    <a href="{{ route('home') }}">
                        <x-application-logo class="block h-10 w-auto fill-current text-gray-300" />
                    </a>
                </div>

                <!-- Navigation Links (desktop) -->
                <div class="hidden md:block">
                    <div class="ml-10 flex items-baseline space-x-4">
                        <x-nav-link :href="route('home')" :active="request()->routeIs('home')">
                            {{ __('Home') }}
                        </x-nav-link>

                        @auth
                            <x-nav-link :href="route('user.posts.index', [auth()->user()] )" :active="request()->routeIs('home.user.posts.show')">
                                {{ __('My Blog') }}
                            </x-nav-link>

                            <x-nav-link :href="route('admin.dashboard')" :active="request()->routeIs('admin.dashboard')">
                                {{ __('Dashboard') }}
                            </x-nav-link>

                            <x-nav-link :href="route('admin.posts.index')" :active="request()->routeIs('admin.posts.*')">
                                {{ __('My Posts') }}
                            </x-nav-link>

                            @can('superadmin')
                                <x-nav-link :href="route('superadmin.posts.index')" :active="request()->routeIs('superadmin.posts.*')">
                                    {{ __('SA: Posts') }}
                                </x-nav-link>
                            @endcan
                        @else
                            <!-- guest menu items -->
                        @endauth
                    </div>
                </div>
            </div>

            <!-- right side (desktop)-->
            <div class="hidden md:block ml-4 flex items-center md:ml-6">
                @auth
                    <!-- Profile dropdown -->
                    <div class="ml-3 relative">
                        <x-dropdown>
                            <!-- Profile icon -->
                            <x-slot name="trigger">
                                <div>
                                    <button type="button" class="max-w-xs bg-gray-800 rounded-full flex items-center text-sm focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-800 focus:ring-white" id="user-menu-button" aria-expanded="false" aria-haspopup="true">
                                        <span class="sr-only">Open user menu</span>
                                        <img class="h-10 w-10 rounded-full" src="{{ auth()->user()->avatar_url }}" alt="avatar">
                                    </button>
                                </div>
                            </x-slot>

                            <!-- dropdown Menu items -->
                            <x-slot name="content">
                                <x-dropdown-link :href="route('profile.edit')" :active="request()->routeIs('profile.*')">
                                    {{ __('Edit Profile') }}
                                </x-dropdown-link>

                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf

                                    <x-dropdown-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();">
                                        {{ __('Sign out') }}
                                    </x-dropdown-link>
                                </form>
                            </x-slot>
                        </x-dropdown>
                    </div>
                @else
                    <!-- login-register nav links (desktop) -->
                    <div class="ml-10 flex items-baseline space-x-4">
                        <x-nav-link :href="route('login')">
                            {{ __('Log in') }}
                        </x-nav-link>

                        <x-nav-link :href="route('register')">
                            {{ __('Register') }}
                        </x-nav-link>
                    </div>
                @endauth
            </div>

            <!-- Hamburger menu -->
            <div class="-mr-2 flex md:hidden">
                <button @click="open = ! open" type="button" class="bg-gray-800 inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-white hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-800 focus:ring-white" aria-controls="mobile-menu" aria-expanded="false">
                    <span class="sr-only">Open main menu</span>
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile menu, show/hide based on menu state. -->
    <div x-cloak :class="{'block': open, 'hidden': ! open}" class="md:hidden" id="mobile-menu">
        <div class="px-2 pt-2 pb-3 space-y-1 sm:px-3">

            <x-responsive-nav-link :href="route('home')" :active="request()->routeIs('home')">
                {{ __('Home') }}
            </x-responsive-nav-link>

            @auth
                <x-responsive-nav-link :href="route('user.posts.index', [auth()->user()] )" :active="request()->routeIs('home.user.posts.show')">
                    {{ __('My Blog') }}
                </x-responsive-nav-link>

                <x-responsive-nav-link :href="route('admin.dashboard')" :active="request()->routeIs('admin.dashboard')">
                    {{ __('Dashboard') }}
                </x-responsive-nav-link>

                <x-responsive-nav-link :href="route('admin.posts.index')" :active="request()->routeIs('admin.posts.*')">
                    {{ __('My Posts') }}
                </x-responsive-nav-link>

                @can('superadmin')
                    <x-responsive-nav-link :href="route('superadmin.posts.index')" :active="request()->routeIs('superadmin.posts.*')">
                        {{ __('SA: Posts') }}
                    </x-responsive-nav-link>
                @endcan
            @endauth

        </div>


        <!-- bottom half (mobile) -->
        <div class="pt-4 pb-3 border-t-2 border-gray-700">

            @auth
                <!-- Profile details (mobile) -->
                <div class="flex items-center mb-3 px-5">
                    <div class="flex-shrink-0">
                        <img class="h-10 w-10 rounded-full" src="{{ auth()->user()->avatar_url }}" alt="avatar">
                    </div>
                    <div class="ml-3">
                        <div class="text-base font-medium leading-none text-white">{{ auth()->user()?->username }}</div>
                        <div class="text-sm font-medium leading-none text-gray-400">{{ auth()->user()?->email }}</div>
                    </div>
                </div>
            @endauth

            <!-- Menu items (mobile) -->

            <div class="px-2 space-y-1">
            @auth
                <!-- Profile Menu items -->
                <x-responsive-nav-link :href="route('profile.edit')" :active="request()->routeIs('profile.*')">
                    {{ __('Edit Profile') }}
                </x-responsive-nav-link>


                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <x-responsive-nav-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();">
                        {{ __('Sign out') }}
                    </x-responsive-nav-link>
                </form>
                @else
                    <x-responsive-nav-link :href="route('login')">
                        {{ __('Log in') }}
                    </x-responsive-nav-link>

                    <x-responsive-nav-link :href="route('register')">
                        {{ __('Register') }}
                    </x-responsive-nav-link>
                @endauth
            </div>


        </div>


    </div>
</nav>
