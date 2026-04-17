@props(['settings'])

<header class="relative h-screen min-h-[600px] flex items-center">
    <div class="absolute inset-0 z-0">
        <img src="https://images.unsplash.com/photo-1540959733332-eab4deabeeaf?auto=format&fit=crop&w=1920&q=80" alt="Hero Background" class="w-full h-full object-cover">
        <div class="absolute inset-0 bg-gradient-to-r from-emerald-950/90 to-emerald-900/60"></div>
    </div>

    <div class="relative z-10 max-w-7xl mx-auto w-full px-6 pt-20">
        <h1 class="text-6xl md:text-8xl font-extrabold text-white drop-shadow-lg mb-4 tracking-tight">
            @php
                $nameParts = explode(' ', $settings->site_name ?? 'Pesantren Darussaadah');
            @endphp
            {{ $nameParts[0] }} <br>
            {{ implode(' ', array_slice($nameParts, 1)) }}
        </h1>
        
        <p class="text-xl md:text-3xl font-medium text-emerald-100 max-w-3xl leading-snug mb-10 drop-shadow-md">
            {{ $settings->site_description ?? 'Membangun Karakter Islami di Era Digital' }}
        </p>
        
        <div class="flex flex-wrap gap-4 mt-4">
            <x-ui.button variant="secondary" href="#about">Tentang Kami</x-ui.button>
            <x-ui.button variant="white-outline" href="{{ route('articles.index') }}">Info Terbaru</x-ui.button>
        </div>
    </div>
</header>