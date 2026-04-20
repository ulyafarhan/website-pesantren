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

            <div class="hidden lg:flex items-center gap-4 z-50">
                <!-- Dropdown PPDB -->
                <div class="relative" x-data="{ open: false }" @click.away="open = false" @mouseleave="open = false">
                    <button @click="open = !open" @mouseover="open = true" class="bg-emerald-700 text-white px-5 py-2.5 rounded text-xs font-extrabold uppercase tracking-wider hover:bg-emerald-600 transition flex items-center gap-2 {{ request()->routeIs('ppdb.*') ? 'bg-emerald-600 shadow-inner' : 'shadow-lg shadow-emerald-700/30 transform hover:-translate-y-0.5' }}">
                        Portal PPDB
                        <svg :class="{'rotate-180': open}" class="w-4 h-4 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </button>
                    
                    <div x-show="open" 
                         x-transition:enter="transition ease-out duration-100"
                         x-transition:enter-start="transform opacity-0 scale-95 -translate-y-2"
                         x-transition:enter-end="transform opacity-100 scale-100 translate-y-0"
                         x-transition:leave="transition ease-in duration-75"
                         x-transition:leave-start="transform opacity-100 scale-100 translate-y-0"
                         x-transition:leave-end="transform opacity-0 scale-95 -translate-y-2"
                         class="absolute right-0 mt-3 w-52 bg-white rounded-xl shadow-2xl overflow-hidden border border-gray-100 flex flex-col"
                         x-cloak>
                        <a href="{{ route('ppdb.register') }}" wire:navigate class="px-5 py-3.5 text-sm font-bold text-gray-800 hover:bg-emerald-50 hover:text-emerald-700 transition flex items-center gap-3 border-b border-gray-50 {{ request()->routeIs('ppdb.register') ? 'bg-emerald-50 text-emerald-700' : '' }}">
                            <span class="text-xl"></span> Daftar Baru
                        </a>
                        <a href="{{ route('ppdb.check') }}" wire:navigate class="px-5 py-3.5 text-sm font-bold text-gray-800 hover:bg-emerald-50 hover:text-emerald-700 transition flex items-center gap-3 {{ request()->routeIs('ppdb.check') ? 'bg-emerald-50 text-emerald-700' : '' }}">
                            <span class="text-xl"></span> Cek Status
                        </a>
                    </div>
                </div>
                <a href="/admin" class="bg-amber-500 text-emerald-950 px-5 py-2.5 rounded text-xs font-extrabold uppercase tracking-wider hover:bg-amber-400 shadow-lg shadow-amber-500/30 transition transform hover:-translate-y-0.5">
                    Admin
                </a>
            </div>

            <div class="lg:hidden">
                <x-navigations.hamburger />
            </div>
        </div>

        <x-navigations.mobile-menu />
    </nav>
</div>