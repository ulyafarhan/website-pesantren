<x-layouts.app :settings="$settings" title="Galeri Kegiatan">
    <div class="max-w-7xl mx-auto px-6 py-12">
        <div class="text-center mb-16">
            <x-ui.badge color="emerald" class="mb-4">DOKUMENTASI VISUAL</x-ui.badge>
            <h1 class="text-4xl md:text-5xl font-extrabold text-gray-900 mb-4">Galeri Pesantren</h1>
            <p class="text-gray-500 max-w-2xl mx-auto">Potret kegiatan santri, fasilitas, dan momen-momen berharga di lingkungan kami.</p>
        </div>

        <div class="columns-1 md:columns-2 lg:columns-3 gap-6 space-y-6">
            @foreach($galleries as $gallery)
                <div class="break-inside-avoid relative group rounded-2xl overflow-hidden shadow-sm">
                    <img src="{{ asset('storage/' . $gallery->image_url) }}" loading="lazy" alt="{{ $gallery->title }}" class="w-full h-auto object-cover transition duration-500 group-hover:scale-110">
                    <div class="absolute inset-0 bg-gradient-to-t from-emerald-950/90 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition duration-300 flex flex-col justify-end p-6">
                        <h3 class="text-white font-bold text-lg">{{ $gallery->title }}</h3>
                        @if($gallery->description)
                            <p class="text-emerald-100 text-sm line-clamp-2 mt-1">{{ $gallery->description }}</p>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</x-layouts.app>