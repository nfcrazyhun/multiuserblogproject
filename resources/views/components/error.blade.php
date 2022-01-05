@props(['error'])

<div>
    @error($error)
        <span class="text-sm text-red-600">{{ $message }}</span>
    @endif
</div>
