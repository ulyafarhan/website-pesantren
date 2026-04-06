@props(['type' => 'info'])

@php
    $types = [
        'success' => 'bg-emerald-50 border-emerald-200 text-emerald-800',
        'error' => 'bg-red-50 border-red-200 text-red-800',
        'warning' => 'bg-amber-50 border-amber-200 text-amber-800',
        'info' => 'bg-blue-50 border-blue-200 text-blue-800',
    ];
    $theme = $types[$type] ?? $types['info'];
@endphp

<div {{ $attributes->merge(['class' => "p-4 rounded-xl border $theme text-sm leading-relaxed"]) }}>
    {{ $slot }}
</div>