<!DOCTYPE html>
<html class="h-full bg-gray-100" lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.gstatic.com/" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">

    <!-- Styles -->
    <link rel="stylesheet" href="{{ mix('css/app.css') }}">

    @livewireStyles

    @stack('styles')
</head>
<body class="h-full font-sans antialiased">
<div class="min-h-screen bg-gray-100">

    <x-navigation />

    {{ $slot }}

    <x-notification />
</div>

<!-- Scripts -->
@livewireScripts

@stack('scripts')

<script src="{{ mix('js/app.js') }}"></script>
</body>
</html>
