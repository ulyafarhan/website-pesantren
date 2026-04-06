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
        <a href="{{ route('home') }}" class="px-4 py-3 rounded-xl text-sm font-bold uppercase tracking-wider text-white hover:bg-emerald-800 transition">Beranda</a>
        <a href="{{ route('programs.index') }}" class="px-4 py-3 rounded-xl text-sm font-bold uppercase tracking-wider text-white hover:bg-emerald-800 transition">Program Kelas</a>
        <a href="{{ route('facilities.index') }}" class="px-4 py-3 rounded-xl text-sm font-bold uppercase tracking-wider text-white hover:bg-emerald-800 transition">Fasilitas</a>
        <a href="{{ route('galleries.index') }}" class="px-4 py-3 rounded-xl text-sm font-bold uppercase tracking-wider text-white hover:bg-emerald-800 transition">Galeri</a>
        <a href="{{ route('articles.index') }}" class="px-4 py-3 rounded-xl text-sm font-bold uppercase tracking-wider text-white hover:bg-emerald-800 transition">Berita</a>
        <a href="{{ route('testimonials.index') }}" class="px-4 py-3 rounded-xl text-sm font-bold uppercase tracking-wider text-white hover:bg-emerald-800 transition">Testimoni</a>
        
        <div class="h-px bg-emerald-800/50 my-3"></div>
        
        <a href="{{ route('ppdb.register') }}" class="px-4 py-3 rounded-xl text-sm font-bold uppercase tracking-wider text-emerald-300 hover:bg-emerald-800 text-center transition border border-emerald-800">Daftar PPDB</a>
        <a href="/admin" class="px-4 py-3 rounded-xl text-sm font-bold uppercase tracking-wider bg-amber-500 text-emerald-950 text-center hover:bg-amber-400 transition shadow-lg mt-2">Login Admin</a>
    </div>
</div>