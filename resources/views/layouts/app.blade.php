<x-base-layout>
    <!-- Page Heading -->
    @isset($header)
    <header class="bg-white shadow">
        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
            <h1 class="text-3xl font-bold text-gray-900 break-words">
                {{ $header }}
            </h1>
        </div>
    </header>
    @endisset

<!-- Page Content -->
    <main>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="p-6 bg-white shadow sm:rounded-lg">
                    {{ $slot }}
                </div>
            </div>
        </div>
    </main>
</x-base-layout>
