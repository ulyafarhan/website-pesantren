<x-layouts.app>
    <div class="py-12 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-extrabold text-gray-900 sm:text-4xl">Fasilitas Pesantren</h2>
                <p class="mt-4 text-xl text-gray-500">Sarana dan prasarana penunjang kegiatan belajar mengajar santri.</p>
            </div>

            <div class="grid grid-cols-1 gap-8 sm:grid-cols-2 lg:grid-cols-3">
                @foreach($facilities as $facility)
                    <div class="bg-gray-50 rounded-2xl overflow-hidden shadow-sm hover:shadow-md transition-shadow">
                        <img class="h-56 w-full object-cover" src="{{ asset('storage/' . $facility->image) }}" alt="{{ $facility->name }}" 
                            onerror="this.onerror=null; this.src='https://placehold.co/600x400?text=Gambar+Tidak+Ada';">
                        <div class="p-6">
                            <h3 class="text-xl font-bold text-gray-900">{{ $facility->name }}</h3>
                            <p class="mt-2 text-gray-600">{{ $facility->description }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</x-layouts.app>