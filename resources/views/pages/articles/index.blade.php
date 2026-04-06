<x-layouts.app :settings="$settings" title="Berita & Artikel">
    <div class="max-w-7xl mx-auto px-6 py-12">
        
        <x-navigations.breadcrumb :items="['Berita & Artikel' => null]" />

        <div class="text-center mb-16">
            <h1 class="text-4xl md:text-5xl font-extrabold text-gray-900 mb-4">Pusat Informasi & Kabar</h1>
            <p class="text-gray-500 max-w-2xl mx-auto">Ikuti terus perkembangan, prestasi, dan kegiatan terbaru dari lingkungan pesantren kami.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($articles as $article)
                <x-ui.card class="flex flex-col h-full group">
                    <div class="overflow-hidden h-56 relative">
                        <img src="{{ asset('storage/' . $article->cover_image) }}" alt="{{ $article->title }}" 
                             onerror="this.src='https://images.unsplash.com/photo-1585828068970-8bf19edbbac2?w=600&q=80';"
                             class="w-full h-full object-cover group-hover:scale-110 transition duration-500">
                        <div class="absolute top-4 left-4 bg-white/90 backdrop-blur-sm px-3 py-1 rounded-full text-xs font-bold text-emerald-700 shadow-sm">
                            {{ $article->published_at ? $article->published_at->format('d M Y') : 'Terbaru' }}
                        </div>
                    </div>
                    <div class="p-6 flex flex-col flex-grow">
                        <h3 class="font-bold text-xl text-gray-900 mb-3 line-clamp-2 group-hover:text-emerald-700 transition">{{ $article->title }}</h3>
                        <p class="text-gray-600 text-sm mb-6 flex-grow line-clamp-3">{{ $article->excerpt }}</p>
                        <a href="{{ route('articles.show', $article->slug) }}" class="text-emerald-600 font-bold text-sm hover:text-amber-500 transition mt-auto flex items-center gap-2">
                            Baca selengkapnya 
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                        </a>
                    </div>
                </x-ui.card>
            @endforeach
        </div>

        <div class="mt-16 flex justify-center">
            {{ $articles->links() }}
        </div>
    </div>
</x-layouts.app>