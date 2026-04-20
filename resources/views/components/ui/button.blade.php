@props(['variant' => 'primary', 'href' => null, 'type' => 'button'])

@php
    $baseClasses = 'inline-flex items-center justify-center px-6 py-3 text-sm font-bold uppercase tracking-wider rounded transition duration-300 shadow-sm focus:outline-none focus:ring-2 focus:ring-offset-2';
    
    $variants = [
        'primary' => 'bg-emerald-600 text-white hover:bg-emerald-700 focus:ring-emerald-500',
        'secondary' => 'bg-amber-500 text-emerald-950 hover:bg-amber-600 focus:ring-amber-500 shadow-amber-500/20',
        'outline' => 'border-2 border-emerald-600 text-emerald-700 hover:bg-emerald-600 hover:text-white focus:ring-emerald-500',
        'white-outline' => 'border-2 border-white/80 text-white hover:bg-white hover:text-emerald-900 backdrop-blur-sm focus:ring-white',
    ];

    $classes = $baseClasses . ' ' . ($variants[$variant] ?? $variants['primary']);
@endphp

@if($href)
    <a href="{{ $href }}" {{ $attributes->merge(['class' => $classes]) }}>
        {{ $slot }}
    </a>
@else
    <button type="{{ $type }}" {{ $attributes->merge(['class' => $classes]) }}>
        {{ $slot }}
    </button>
@endif