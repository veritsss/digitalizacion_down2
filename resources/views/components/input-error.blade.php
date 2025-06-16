@props(['messages'])

@if ($messages)
    <div {{ $attributes->merge(['class' => 'text-danger mt-1']) }}>
        @foreach ((array) $messages as $message)
            <div>{{ $message }}</div>
        @endforeach
    </div>
@endif
