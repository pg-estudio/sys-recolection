@props(['messages' => null])

@if ($messages)
    <p {{ $attributes->merge(['class' => 'mt-2 text-sm text-red-600 dark:text-red-500']) }}>
        @if (is_array($messages))
            {{ implode(', ', $messages) }}
        @else
            {{ $messages }}
        @endif
    </p>
@endif
