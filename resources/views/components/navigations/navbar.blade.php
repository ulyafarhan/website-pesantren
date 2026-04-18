@props(['settings'])

@php
    $isHome = request()->routeIs('home');
@endphp

<div x-data="{ mobileMenuOpen: false, scrolled: false }" 
     @scroll.window="scrolled = (window.pageYOffset > 20)"
     class="relative">

    <nav :class="{
             'bg-emerald-950/95 backdrop-blur-md shadow-lg py-4': scrolled || !@json($isHome), 
             'bg-transparent py-6': !scrolled && @json($isHome)
         }"
         class="fixed w-full z-50 top-0 left-0 transition-all duration-300">
        
        <div class="max-w-7xl mx-auto px-6 flex justify-between items-center text-white">
            
            <a href="{{ route('home') }}" wire:navigate class="flex items-center gap-3 drop-shadow-md hover:scale-105 transition-transform duration-300 z-50">
                <div class="bg-transparent p-1 rounded-lg shadow-inner">
                    <img class="h-10 w-auto object-contain" 
                         src="{{ asset('images/logo-darussaadah.png') }}" 
                         alt="Logo"
                         onerror="this.src='https://ui-avatars.com/api/?name=P&background=fbbf24&color=064e3b'">
                </div>
                <div class="flex flex-col">
                    <span class="font-bold text-lg leading-none tracking-tight">
                        {{ $settings->name ?? 'Darussaadah' }}
                    </span>
                    <span class="text-[10px] uppercase tracking-[0.2em] opacity-80 font-medium">
                        Pesantren Terpadu
                    </span>
                </div>
            </a>

            <div class="hidden lg:flex gap-8 text-xs font-bold uppercase tracking-widest drop-shadow-md items-center">
                <a href="{{ route('home') }}" wire:navigate class="hover:text-amber-400 transition {{ request()->routeIs('home') ? 'text-amber-400' : '' }}">Beranda</a>
                <a href="{{ route('programs.index') }}" wire:navigate class="hover:text-amber-400 transition {{ request()->routeIs('programs.*') ? 'text-amber-400' : '' }}">Program</a>
                <a href="{{ route('facilities.index') }}" wire:navigate class="hover:text-amber-400 transition {{ request()->routeIs('facilities.*') ? 'text-amber-400' : '' }}">Fasilitas</a>
                <a href="{{ route('galleries.index') }}" wire:navigate class="hover:text-amber-400 transition {{ request()->routeIs('galleries.*') ? 'text-amber-400' : '' }}">Galeri</a>
                <a href="{{ route('articles.index') }}" wire:navigate class="hover:text-amber-400 transition {{ request()->routeIs('articles.*') ? 'text-amber-400' : '' }}">Berita</a>
                <a href="{{ route('testimonials.index') }}" wire:navigate class="hover:text-amber-400 transition {{ request()->routeIs('testimonials.*') ? 'text-amber-400' : '' }}">Testimoni</a>
            </div>

            <div class="hidden lg:flex items-center gap-6 z-50">
                <a href="{{ route('ppdb.register') }}" wire:navigate class="text-xs font-bold uppercase tracking-wider text-emerald-100 hover:text-amber-400 transition">
                    Daftar PPDB
                </a>
                <a href="/admin" class="bg-amber-500 text-emerald-950 px-5 py-2.5 rounded text-xs font-extrabold uppercase tracking-wider hover:bg-amber-400 shadow-lg shadow-amber-500/30 transition transform hover:-translate-y-0.5">
                    Login
                </a>
            </div>

            <div class="lg:hidden">
                <x-navigations.hamburger />
            </div>
        </div>

        <x-navigations.mobile-menu />
    </nav>
</div>