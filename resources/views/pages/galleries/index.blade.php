<x-layouts.app :settings="$settings" title="Galeri Kegiatan">
    <div class="max-w-7xl mx-auto px-6 py-12">
        <div class="text-center mb-16">
            <x-ui.badge color="emerald" class="mb-4">DOKUMENTASI VISUAL</x-ui.badge>
            <h1 class="text-4xl md:text-5xl font-extrabold text-gray-900 mb-4">Galeri Pesantren</h1>
            <p class="text-gray-500 max-w-2xl mx-auto">Potret kegiatan santri, fasilitas, dan momen-momen berharga di lingkungan kami.</p>
        </div>

        {{-- Menggunakan Grid agar tinggi kartu seragam --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($galleries as $gallery)
                <div class="group relative m-0 flex h-72 w-full rounded shadow-xl transition duration-300 ease-in-out hover:scale-105 hover:shadow-2xl hover:shadow-emerald-600/5 overflow-hidden">
                    {{-- Container Gambar --}}
                    <div class="z-10 h-full w-full overflow-hidden rounded border border-gray-200 opacity-90 transition duration-300 ease-in-out group-hover:opacity-100 white:border-white-700">
                        <img src="{{ asset('storage/' . $gallery->image_url) }}" 
                             class="block h-full w-full scale-100 transform object-cover object-center transition duration-500 group-hover:scale-110" 
                             alt="{{ $gallery->title }}"
                             onerror="this.src='https://placehold.co/600x400?text=Gambar+Tidak+Ada';" />
                        
                        {{-- Overlay Gelap agar teks terbaca --}}
                        <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/20 to-transparent opacity-60 group-hover:opacity-80 transition-opacity duration-300"></div>
                    </div>

                    {{-- Konten Teks --}}
                    <div class="absolute bottom-0 z-20 m-0 pb-6 ps-6 transition duration-300 ease-in-out group-hover:-translate-y-2 group-hover:translate-x-2">
                        <h1 class="font-sans text-xl font-bold text-white drop-shadow-lg">
                            {{ $gallery->title }}
                        </h1>
                        @if($gallery->description)
                            <p class="text-sm font-light text-gray-200 opacity-0 group-hover:opacity-100 transition-opacity duration-500 delay-100 line-clamp-1 pr-4">
                                {{ $gallery->description }}
                            </p>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
        
        {{-- Pagination --}}
        <div class="mt-12">
            {{ $galleries->links() }}
        </div>
    </div>
</x-layouts.app>