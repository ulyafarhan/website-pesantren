@props(['galleries'])

<section id="projects" class="py-24 px-6 max-w-7xl mx-auto">
    <div class="flex flex-col lg:flex-row gap-12 items-center">
        <div class="w-full lg:w-1/3 order-2 lg:order-1 bg-emerald-50 p-10 rounded-3xl border border-emerald-100">
            <p class="text-emerald-600 font-bold uppercase tracking-widest text-xs mb-3">GALERI KEGIATAN</p>
            <h2 class="text-3xl font-extrabold text-gray-900 mb-6 leading-tight">Puncak Kreasi <br><span class="text-emerald-600">Lingkungan Kami</span></h2>
            <p class="text-gray-600 text-sm mb-8 leading-relaxed">
                Lihat bagaimana lingkungan kampus kami didesain untuk mendukung kegiatan yang kondusif, berpadu dengan keasrian alam untuk seluruh anggota.
            </p>
            <a href="#" class="inline-block bg-emerald-600 text-white px-6 py-3 rounded text-xs font-bold uppercase tracking-wider hover:bg-emerald-700 transition">LIHAT GALERI FULL</a>
        </div>
        
        <div class="w-full lg:w-2/3 order-1 lg:order-2 grid grid-cols-2 md:grid-cols-3 gap-4">
            @foreach($galleries->take(6) as $index => $gallery)
                <div class="rounded-xl overflow-hidden h-40 md:h-48 shadow-sm">
                    <img src="{{ asset('storage/' . $gallery->image_url) }}" alt="{{ $gallery->title }}" onerror="this.onerror=null;this.src='https://images.unsplash.com/photo-1542838132-92c53300491e?auto=format&fit=crop&w=600&q=80';" class="w-full h-full object-cover hover:scale-110 transition duration-500">
                </div>
            @endforeach
        </div>
    </div>
</section>