<div x-show="mobileMenuOpen" 
     x-transition:enter="transition ease-out duration-300 transform"
     x-transition:enter-start="opacity-0 -translate-y-10"
     x-transition:enter-end="opacity-100 translate-y-0"
     x-transition:leave="transition ease-in duration-200 transform"
     x-transition:leave-start="opacity-100 translate-y-0"
     x-transition:leave-end="opacity-0 -translate-y-10"
     @click.away="mobileMenuOpen = false"
     x-cloak 
     class="lg:hidden absolute top-full left-0 w-full bg-emerald-950/95 backdrop-blur-xl border-t border-emerald-800 shadow-2xl max-h-[85vh] overflow-y-auto">
    
    <div class="px-6 py-6 flex flex-col gap-2">
        <a href="{{ route('home') }}" wire:navigate @click="mobileMenuOpen = false" class="px-4 py-3 rounded text-sm font-bold uppercase tracking-wider transition {{ request()->routeIs('home') ? 'bg-emerald-800 text-amber-400' : 'text-white hover:bg-emerald-800' }}">Beranda</a>
        <a href="{{ route('programs.index') }}" wire:navigate @click="mobileMenuOpen = false" class="px-4 py-3 rounded text-sm font-bold uppercase tracking-wider transition {{ request()->routeIs('programs.*') ? 'bg-emerald-800 text-amber-400' : 'text-white hover:bg-emerald-800' }}">Program Kelas</a>
        <a href="{{ route('facilities.index') }}" wire:navigate @click="mobileMenuOpen = false" class="px-4 py-3 rounded text-sm font-bold uppercase tracking-wider transition {{ request()->routeIs('facilities.*') ? 'bg-emerald-800 text-amber-400' : 'text-white hover:bg-emerald-800' }}">Fasilitas</a>
        <a href="{{ route('galleries.index') }}" wire:navigate @click="mobileMenuOpen = false" class="px-4 py-3 rounded text-sm font-bold uppercase tracking-wider transition {{ request()->routeIs('galleries.*') ? 'bg-emerald-800 text-amber-400' : 'text-white hover:bg-emerald-800' }}">Galeri</a>
        <a href="{{ route('articles.index') }}" wire:navigate @click="mobileMenuOpen = false" class="px-4 py-3 rounded text-sm font-bold uppercase tracking-wider transition {{ request()->routeIs('articles.*') ? 'bg-emerald-800 text-amber-400' : 'text-white hover:bg-emerald-800' }}">Berita</a>
        <a href="{{ route('testimonials.index') }}" wire:navigate @click="mobileMenuOpen = false" class="px-4 py-3 rounded text-sm font-bold uppercase tracking-wider transition {{ request()->routeIs('testimonials.*') ? 'bg-emerald-800 text-amber-400' : 'text-white hover:bg-emerald-800' }}">Testimoni</a>
        
        <div class="h-px bg-emerald-800/50 my-3"></div>
        
        <p class="px-4 text-[10px] font-bold text-emerald-500 uppercase tracking-widest mb-1 mt-2">Portal PPDB</p>
        <div class="grid grid-cols-2 gap-2">
            <a href="{{ route('ppdb.register') }}" wire:navigate @click="mobileMenuOpen = false" class="px-3 py-3 rounded text-xs font-bold uppercase tracking-wider text-center transition bg-emerald-700 text-white hover:bg-emerald-600 {{ request()->routeIs('ppdb.register') ? 'ring-2 ring-amber-400' : '' }}">Daftar</a>
            <a href="{{ route('ppdb.check') }}" wire:navigate @click="mobileMenuOpen = false" class="px-3 py-3 rounded text-xs font-bold uppercase tracking-wider text-center transition border border-emerald-800 {{ request()->routeIs('ppdb.check') ? 'bg-emerald-800 text-amber-400' : 'text-emerald-300 hover:bg-emerald-800' }}">Status</a>
        </div>
        
        <div class="h-px bg-emerald-800/50 my-3"></div>
        <a href="/admin" class="px-4 py-3 rounded text-sm font-bold uppercase tracking-wider bg-amber-500 text-emerald-950 text-center hover:bg-amber-400 transition shadow-lg mt-2">Login Admin</a>
    </div>
</div>