{{-- resources/views/pages/articles/show.blade.php --}}
<x-layouts.app :settings="$settings" :title="$article->title">
    {{-- JSON-LD Article Schema untuk SEO --}}
    @push('head')
    @php
        $articleJsonLd = [
            '@context'      => 'https://schema.org',
            '@type'         => 'Article',
            'headline'      => $article->title,
            'description'   => \Illuminate\Support\Str::limit(strip_tags($article->excerpt ?? ''), 160),
            'image'         => $article->cover_image,
            'datePublished' => $article->published_at?->toIso8601String(),
            'dateModified'  => $article->updated_at?->toIso8601String(),
            'author' => [
                '@type' => 'Person',
                'name'  => $article->author->name ?? 'Admin',
            ],
            'publisher' => [
                '@type' => 'Organization',
                'name'  => $settings->site_name ?? 'Pesantren Darussaadah',
                'logo'  => [
                    '@type' => 'ImageObject',
                    'url'   => asset('images/logo-darussaadah.png'),
                ],
            ],
        ];
    @endphp
    <script type="application/ld+json">{!! json_encode($articleJsonLd, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT) !!}</script>
    @endpush

    <article class="max-w-4xl mx-auto px-6 py-12">
        
        {{-- Breadcrumb --}}
        <x-navigations.breadcrumb :items="[
            'Berita' => route('articles.index'),
            $article->title => null
        ]" />

        {{-- Judul & Meta --}}
        <header class="mb-10">
            <h1 class="text-4xl md:text-5xl font-extrabold text-gray-900 leading-tight mb-4">
                {{ $article->title }}
            </h1>
            <div class="flex items-center gap-4 text-sm text-gray-500">
                <span class="font-semibold text-emerald-600">{{ $article->author->name }}</span>
                <span>•</span>
                <span>{{ $article->published_at->format('d M Y') }}</span>
            </div>
        </header>

        {{-- Gambar Cover --}}
        @if($article->cover_image)
            <div class="rounded overflow-hidden mb-10 shadow-lg">
                <img src="{{ $article->cover_image }}" 
                     alt="{{ $article->title }}" 
                     class="w-full h-auto object-cover"
                     onerror="this.src='https://placehold.co/1200x600?text=Gambar+Berita'">
            </div>
        @endif

        {{-- Konten Utama --}}
        {{-- Gunakan {!! !!} karena konten biasanya berisi tag HTML dari Rich Editor (Filament) --}}
        <div class="prose prose-lg prose-emerald max-w-none text-gray-700 leading-relaxed">
            {!! $article->content !!}
        </div>

    </article>
</x-layouts.app>