<x-layouts.app :settings="$settings" title="Tentang Kami">
    <div class="pt-32 pb-12 px-6 bg-emerald-950 text-white">
        <div class="max-w-7xl mx-auto">
            <x-navigations.breadcrumb :items="['Tentang Kami' => null]" />
            <h1 class="text-4xl md:text-5xl font-extrabold mb-4">Profil & Sejarah</h1>
            <p class="text-emerald-200">Mengenal lebih dekat lingkungan, visi, dan misi kami.</p>
        </div>
    </div>

    <x-sections.about />

    <section class="py-16 px-6 max-w-7xl mx-auto">
        <div class="bg-white rounded-3xl p-10 lg:p-16 border border-gray-100 shadow-[0_4px_20px_-4px_rgba(0,0,0,0.05)]">
            <div class="text-center mb-12">
                <p class="text-emerald-600 font-bold uppercase tracking-widest text-xs mb-3">INFRASTRUKTUR</p>
                <h2 class="text-3xl font-extrabold text-gray-900">Fasilitas Kami</h2>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-10">
                @foreach($facilities ?? [] as $facility)
                    <div class="text-center group">
                        <div class="overflow-hidden rounded-2xl mb-6 shadow-sm">
                            <img src="{{ asset('storage/' . $facility->image_url) }}" alt="{{ $facility->name }}" onerror="this.src='https://images.unsplash.com/photo-1540959733332-eab4deabeeaf?auto=format&fit=crop&w=600&q=80';" class="w-full h-56 object-cover group-hover:scale-105 transition duration-500">
                        </div>
                        <h3 class="font-bold text-gray-900 text-xl mb-3">{{ $facility->name }}</h3>
                        <p class="text-sm text-gray-600 leading-relaxed">{{ $facility->description }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
</x-layouts.app>