@props(['settings'])

@php
    $isHome = request()->routeIs('home');
@endphp

<nav x-data="{ mobileMenuOpen: false, scrolled: false }" 
     @scroll.window="scrolled = (window.pageYOffset > 20)"
     :class="{
         'bg-emerald-950/95 backdrop-blur-md shadow-lg py-4': scrolled || !{{ $isHome ? 'true' : 'false' }}, 
         'bg-transparent py-6': !scrolled && {{ $isHome ? 'true' : 'false' }}
     }"
     class="fixed w-full z-50 top-0 left-0 transition-all duration-300 {{ !$isHome ? 'bg-emerald-950 shadow-lg py-4' : '' }}">
    
    <div class="max-w-7xl mx-auto px-6 flex justify-between items-center text-white">
        <a href="{{ route('home') }}" class="flex items-center gap-2 drop-shadow-md hover:scale-105 transition-transform duration-300 z-50">
            <svg class="w-8 h-8 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
            <span class="font-bold text-xl tracking-tight">{{ $settings->site_name ?? 'Pesantren' }}</span>
        </a>
        
        <div class="hidden lg:flex gap-8 text-xs font-bold uppercase tracking-widest drop-shadow-md items-center">
            <a href="{{ route('home') }}" class="hover:text-amber-400 transition {{ request()->routeIs('home') ? 'text-amber-400' : '' }}">Beranda</a>
            <a href="{{ route('programs.index') }}" class="hover:text-amber-400 transition {{ request()->routeIs('programs.*') ? 'text-amber-400' : '' }}">Program</a>
            <a href="{{ route('facilities.index') }}" class="hover:text-amber-400 transition {{ request()->routeIs('facilities.*') ? 'text-amber-400' : '' }}">Fasilitas</a>
            <a href="{{ route('galleries.index') }}" class="hover:text-amber-400 transition {{ request()->routeIs('galleries.*') ? 'text-amber-400' : '' }}">Galeri</a>
            <a href="{{ route('articles.index') }}" class="hover:text-amber-400 transition {{ request()->routeIs('articles.*') ? 'text-amber-400' : '' }}">Berita</a>
            <a href="{{ route('testimonials.index') }}" class="hover:text-amber-400 transition {{ request()->routeIs('testimonials.*') ? 'text-amber-400' : '' }}">Testimoni</a>
        </div>
        
        <div class="hidden lg:flex items-center gap-3 z-50">
            <a href="{{ route('ppdb.register') }}" class="text-xs font-bold uppercase tracking-wider text-emerald-100 hover:text-white transition">
                Daftar PPDB
            </a>
            <a href="/admin" class="bg-amber-500 text-emerald-950 px-5 py-2.5 rounded text-xs font-extrabold uppercase tracking-wider hover:bg-amber-400 shadow-lg shadow-amber-500/30 transition transform hover:-translate-y-0.5">
                Login
            </a>
        </div>

        <x-navigations.hamburger />
    </div>

    <x-navigations.mobile-menu />
</nav>