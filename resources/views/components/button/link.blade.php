<button
    {{ $attributes->merge([
        'type' => 'button',
        'class' => 'text-gray-700 text-sm leading-5 font-medium focus:outline-none focus:text-gray-800 focus:underline hover:underline' . ($attributes->get('disabled') ? ' opacity-75 cursor-not-allowed' : ''),
    ]) }}
>
    {{ $slot }}
</button>
