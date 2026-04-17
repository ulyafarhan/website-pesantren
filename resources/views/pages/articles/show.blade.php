<x-layouts.app :settings="$settings" :title="$article->title">
    <div class="max-w-4xl mx-auto px-6 py-12">
        
        <x-navigations.breadcrumb :items="[
            'Berita' => route('articles.index'),
            Str::limit($article->title, 30) => null
        ]" />

        <article class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden mt-8">
            <div class="h-[300px] md:h-[450px] w-full relative">
                <img src="{{ $article->cover_image }}" alt="{{ $article->title }}" 
                     onerror="this.src='https://images.unsplash.com/photo-1585828068970-8bf19edbbac2?w=1000&q=80';"
                     class="w-full h-full object-cover">
            </div>
            
            <div class="p-8 md:p-14">
                <div class="flex items-center gap-4 text-sm text-gray-500 font-medium mb-6">
                    <div class="flex items-center gap-1.5">
                        <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        {{ $article->published_at ? $article->published_at->translatedFormat('l, d F Y') : '-' }}
                    </div>
                    <div class="flex items-center gap-1.5">
                        <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                        {{ $article->author->name ?? 'Redaksi' }}
                    </div>
                </div>

                <h1 class="text-3xl md:text-5xl font-extrabold text-gray-900 mb-8 leading-tight">{{ $article->title }}</h1>
                
                <div class="prose prose-lg prose-emerald max-w-none text-gray-700 leading-relaxed">
                    {!! $article->content !!}
                </div>
            </div>
        </article>

        <div class="mt-10 text-center">
            <x-ui.button variant="outline" href="{{ route('articles.index') }}">
                &larr; Kembali ke Daftar Berita
            </x-ui.button>
        </div>
    </div>
</x-layouts.app>