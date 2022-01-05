@props(['type' => 'button'])
<x-button :type="$type" {{ $attributes->merge(['class' => 'border-red-300 bg-red-600 text-white active:bg-red-700 hover:bg-red-500']) }}>{{ $slot }}</x-button>
