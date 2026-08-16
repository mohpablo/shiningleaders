@props(['disabled' => false])

<input {{ $disabled ? 'disabled' : '' }} {{ $attributes->merge([
    'class' => 'w-full bg-white border-2 border-midnight px-4 py-3 font-medium text-midnight focus:outline-none focus:border-terracotta focus:ring-0 shadow-[3px_3px_0px_0px_#0B132B] transition-all disabled:opacity-50'
]) }}>