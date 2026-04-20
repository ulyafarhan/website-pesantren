@props(['messages' => null, 'name' => null])

@if ($messages)
    <ul {{ $attributes->merge(['class' => 'text-sm text-red-600 space-y-1 mt-2 font-medium']) }}>
        @foreach ((array) $messages as $message)
            <li>{{ $message }}</li>
        @endforeach
    </ul>
@elseif ($name)
    @error($name)
        <p {{ $attributes->merge(['class' => 'text-sm text-red-600 mt-2 font-medium']) }}>{{ $message }}</p>
    @enderror
@endif