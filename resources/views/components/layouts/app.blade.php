<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    {{-- Variabel settings diberikan fallback agar tidak error jika database kosong --}}
    <meta name="description" content="{{ $settings->site_description ?? 'Sistem Informasi Pesantren Darussaadah' }}">
    <meta name="og:image" content="{{ asset('images/logo-darussaadah.png') }}">

    <title>{{ $title ?? 'Beranda' }} - {{ $settings->site_name ?? 'Pesantren Darussaadah' }}</title>

    {{-- Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    {{-- Assets & Scripts --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    {{-- Alpine.js dikelola oleh Vite di resources/js/app.js, 
         tapi jika Anda ingin manual via CDN, pastikan hanya ada satu --}}
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
</head>
<body class="bg-gray-50 text-gray-800 antialiased bg-topography flex flex-col min-h-screen">

    {{-- Kirim data settings ke navbar --}}
    <x-navigations.navbar :settings="$settings" />

    {{-- Logika padding top: Jika di halaman home (transparan), tidak perlu padding. 
         Jika di halaman lain, berikan padding agar konten tidak tertutup navbar fixed --}}
    <main id="swup" class="transition-fade flex-grow {{ request()->routeIs('home') ? '' : 'pt-20 lg:pt-28' }}">
        {{ $slot }}
    </main>

    {{-- Footer --}}
    <x-navigations.footer :settings="$settings" />

    {{-- Bersihkan Cache Blade otomatis jika ada perubahan --}}
</body>
</html>