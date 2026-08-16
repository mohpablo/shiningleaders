<button {{ $attributes->merge([
    'type' => 'submit', 
    'class' => 'w-full bg-terracotta hover:bg-amber-700 text-white font-bold py-3.5 px-6 border-2 border-midnight shadow-[4px_4px_0px_0px_#0B132B] hover:translate-x-0.5 hover:translate-y-0.5 hover:shadow-none transition-all cursor-pointer'
]) }}>
    {{ $slot }}
</button>