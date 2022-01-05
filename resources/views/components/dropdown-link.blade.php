@props(['active'])

@php
    $classes = ($active ?? false)
                ? 'block px-4 py-2 bg-gray-100 text-sm text-gray-700'
                : 'block px-4 py-2 hover:bg-gray-200 text-sm text-gray-700';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
