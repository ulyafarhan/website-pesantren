<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="{{ $settings->site_description ?? 'Sistem Informasi Pesantren Darussaadah' }}">
    <meta name="robots" content="index, follow">

    {{-- Open Graph --}}
    <meta property="og:type" content="website">
    <meta property="og:title" content="{{ $title ?? 'Beranda' }} - {{ $settings->site_name ?? 'Pesantren Darussaadah' }}">
    <meta property="og:description" content="{{ $settings->site_description ?? 'Sistem Informasi Pesantren Darussaadah' }}">
    <meta property="og:image" content="{{ asset('images/logo-darussaadah.png') }}">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:locale" content="id_ID">

    {{-- JSON-LD Schema.org — Organization (SEO & AI Crawlers) --}}
    @php
        $sameAs = array_filter([
            $settings->facebook_url  ?? null,
            $settings->instagram_url ?? null,
            $settings->youtube_url   ?? null,
        ]);

        $jsonLd = [
            '@context'    => 'https://schema.org',
            '@graph'      => [
                array_filter([
                    '@type'       => 'EducationalOrganization',
                    '@id'         => url('/') . '#organization',
                    'name'        => $settings->site_name        ?? 'Pesantren Darussaadah',
                    'description' => $settings->site_description ?? 'Sistem Informasi Pesantren',
                    'url'         => url('/'),
                    'logo'        => asset('images/logo-darussaadah.png'),
                    'email'       => $settings->email   ?? null,
                    'telephone'   => $settings->phone   ?? null,
                    'address'     => $settings->address ? ['@type' => 'PostalAddress', 'streetAddress' => $settings->address] : null,
                    'sameAs'      => count($sameAs) ? array_values($sameAs) : null,
                ]),
                [
                    '@type'       => 'WebSite',
                    '@id'         => url('/') . '#website',
                    'url'         => url('/'),
                    'name'        => $settings->site_name ?? 'Pesantren Darussaadah',
                    'publisher'   => ['@id' => url('/') . '#organization'],
                ]
            ]
        ];
    @endphp
    <script type="application/ld+json">{!! json_encode($jsonLd, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT) !!}</script>
    <title>{{ $title ?? 'Beranda' }} - {{ $settings->site_name ?? 'Pesantren Darussaadah' }}</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <script defer src="https://cdn.jsdelivr.net/npm/@alpinejs/intersect@3.x.x/dist/cdn.min.js"></script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        .bg-topography {
            background-image: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%2310b981' fill-opacity='0.03'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
        }
        .transition-fade {
            transition: 0.4s opacity;
        }
        html.is-animating .transition-fade {
            opacity: 0;
        }
    </style>

    @stack('head')
</head>
<body class="font-sans antialiased text-gray-900 bg-slate-50 flex flex-col min-h-screen">

    <x-navigations.navbar :settings="$settings" />

    <main class="flex-grow {{ request()->routeIs('home') ? '' : 'pt-32' }}">
        {{ $slot }}
    </main>

    <x-navigations.footer :settings="$settings" />

</body>
</html>