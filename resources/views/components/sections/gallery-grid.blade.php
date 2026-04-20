@props(['galleries'])

<section id="projects" class="py-24 px-6 max-w-7xl mx-auto">
    <div class="flex flex-col lg:flex-row gap-12 items-center">
        <div class="w-full lg:w-1/3 order-2 lg:order-1 bg-emerald-50 p-10 rounded border border-emerald-100">
            <p class="text-emerald-600 font-bold uppercase tracking-widest text-xs mb-3">GALERI KEGIATAN</p>
            <h2 class="text-3xl font-extrabold text-gray-900 mb-6 leading-tight">Puncak Kreasi <br><span class="text-emerald-600">Lingkungan Kami</span></h2>
            <p class="text-gray-600 text-sm mb-8 leading-relaxed">
                Lihat bagaimana lingkungan kampus kami didesain untuk mendukung kegiatan yang kondusif.
            </p>
            <a href="{{ route('galleries.index') }}" wire:navigate class="inline-block bg-emerald-600 text-white px-6 py-3 rounded text-xs font-bold uppercase tracking-wider hover:bg-emerald-700 transition shadow-lg shadow-emerald-200">
                LIHAT GALERI FULL
            </a>
        </div>
        
        <div class="w-full lg:w-2/3 order-1 lg:order-2 grid grid-cols-1 sm:grid-cols-2 gap-4">
            @foreach($galleries->take(4) as $gallery)
                <div class="group relative flex h-60 w-full rounded shadow-md overflow-hidden">
                    <div class="h-full w-full transition duration-300 ease-in-out">
                        <img src="{{ asset('storage/' . $gallery->image_url) }}" 
                             alt="{{ $gallery->title }}" 
                             onerror="this.src='https://placehold.co/600x400?text=Gambar+Tidak+Ada';" 
                             class="h-full w-full object-cover transition duration-500 group-hover:scale-110">
                        <div class="absolute inset-0 bg-gradient-to-t from-emerald-950/90 to-transparent opacity-70"></div>
                    </div>
                    
                    <div class="absolute bottom-0 p-4 transition duration-300 group-hover:translate-x-2">
                        <h3 class="text-white font-bold text-base">{{ $gallery->title }}</h3>
                        <p class="text-emerald-200 text-xs opacity-0 group-hover:opacity-100 transition-opacity duration-300 line-clamp-1">Lihat Detail</p>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>