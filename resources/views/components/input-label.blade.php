@props(['value'])

<label {{ $attributes->merge(['class' => 'block font-bold text-sm text-midnight mb-1.5']) }}>
    {{ $value ?? $slot }}
</label>