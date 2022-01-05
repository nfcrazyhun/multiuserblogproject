@props([
    'status',
])
<span
    {{ $attributes->merge([
        'class' => "inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold leading-4 capitalize btn-$status"
        ]) }}
>
    {{ $status }}

{{-- Secure classes to css --}}
    <span class="btn-draft btn-pending btn-published btn-archived btn-unknown" style="display: none"></span>

</span>

