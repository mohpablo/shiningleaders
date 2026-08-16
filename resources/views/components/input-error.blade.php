@props(['messages'])

@if ($messages)
    <ul {{ $attributes->merge(['class' => 'text-xs font-bold text-red-600 mt-1.5 space-y-1']) }}>
        @foreach ((array) $messages as $message)
            <li class="bg-red-50 border border-red-500 p-2 border-midnight">{{ $message }}</li>
        @endforeach
    </ul>
@endif