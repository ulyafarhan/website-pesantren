@props(['articles'])

<section id="berita" class="py-24 px-6 bg-white">
    <div class="max-w-7xl mx-auto">
        <div class="text-center mb-16">
            <p class="text-emerald-600 font-bold uppercase tracking-widest text-xs mb-3">KABAR TERKINI</p>
            <h2 class="text-4xl font-extrabold text-gray-900">Berita & Artikel Terbaru</h2>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            @foreach($articles as $article)
                <div class="bg-gray-50 rounded-2xl overflow-hidden shadow-sm hover:shadow-lg transition duration-300 border border-gray-100 flex flex-col">
                    <img 
                        src="{{ asset('storage/' . $article->cover_image) }}" 
                        alt="{{ $article->title }}" 
                        onerror="this.onerror=null;this.src='https://images.unsplash.com/photo-1585828068970-8bf19edbbac2?auto=format&fit=crop&w=600&q=80';"
                        class="w-full h-52 object-cover"
                    >
                    <div class="p-6 flex flex-col flex-grow">
                        <p class="text-xs text-emerald-600 font-bold mb-2">{{ $article->published_at ? $article->published_at->format('d M Y') : 'Terbaru' }}</p>
                        <h3 class="font-bold text-xl text-gray-900 mb-3 line-clamp-2">{{ $article->title }}</h3>
                        <p class="text-gray-600 text-sm mb-6 flex-grow line-clamp-3">{{ $article->excerpt }}</p>
                        <a href="{{ route('articles.show', $article->slug) }}" class="text-emerald-700 font-bold text-sm hover:text-amber-500 transition mt-auto">Baca selengkapnya &rarr;</a>
                    </div>
                </div>
            @endforeach
        </div>
        
        <div class="text-center mt-12">
            <a href="{{ route('articles.index') }}" class="inline-block border-2 border-emerald-600 text-emerald-700 px-8 py-3 rounded text-sm font-bold uppercase tracking-wider hover:bg-emerald-600 hover:text-white transition">Lihat Semua Berita</a>
        </div>
    </div>
</section>