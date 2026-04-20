@props(['items'])

@php
    $breadcrumbJson = [
        '@context' => 'https://schema.org',
        '@type' => 'BreadcrumbList',
        'itemListElement' => [
            [
                '@type' => 'ListItem',
                'position' => 1,
                'name' => 'Beranda',
                'item' => route('home')
            ]
        ]
    ];
    
    $position = 2;
    foreach($items as $label => $url) {
        $item = [
            '@type' => 'ListItem',
            'position' => $position,
            'name' => $label,
        ];
        if ($url) {
            $item['item'] = $url;
        }
        $breadcrumbJson['itemListElement'][] = $item;
        $position++;
    }
@endphp

@push('head')
<script type="application/ld+json">{!! json_encode($breadcrumbJson, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}</script>
@endpush

<nav class="flex text-sm text-gray-500 font-medium mb-8 overflow-x-auto whitespace-nowrap pb-2 scrollbar-hide" aria-label="Breadcrumb">
    <ol class="inline-flex items-center space-x-1 md:space-x-3">
        <li class="inline-flex items-center">
            <a href="{{ route('home') }}" wire:navigate class="inline-flex items-center gap-1.5 hover:text-emerald-600 transition text-gray-600 hover:bg-emerald-50 px-2 py-1 rounded-md">
                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"></path></svg>
                Beranda
            </a>
        </li>
        @foreach($items as $label => $url)
            <li>
                <div class="flex items-center">
                    <svg class="w-5 h-5 text-gray-400 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>
                    @if($url)
                        <a href="{{ $url }}" wire:navigate class="ml-1 md:ml-2 hover:text-emerald-600 transition text-gray-600 hover:bg-emerald-50 px-2 py-1 rounded-md">{{ $label }}</a>
                    @else
                        <span class="ml-1 md:ml-2 text-emerald-800 font-bold px-2 py-1">{{ $label }}</span>
                    @endif
                </div>
            </li>
        @endforeach
    </ol>
</nav>