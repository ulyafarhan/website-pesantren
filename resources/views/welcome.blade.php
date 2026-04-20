<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $settings->site_name ?? 'UKM PTQ Unimal' }}</title>
    @vite(['resources/css/app.css'])
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        .bg-topography {
            background-image: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%2310b981' fill-opacity='0.03'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
        }
    </style>
</head>
<body class="bg-gray-50 text-gray-800 antialiased bg-topography">

    <nav class="absolute w-full z-50 top-0 left-0 pt-6 px-6">
        <div class="max-w-7xl mx-auto flex justify-between items-center text-white">
            <div class="flex items-center gap-2 drop-shadow-md">
                <svg class="w-8 h-8 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                <span class="font-bold text-xl tracking-tight">{{ $settings->site_name ?? 'UKM PTQ' }}</span>
            </div>
            <div class="hidden md:flex gap-8 text-xs font-bold uppercase tracking-widest drop-shadow-md">
                <a href="#about" class="hover:text-amber-400 transition">Tentang Kami</a>
                <a href="#services" class="hover:text-amber-400 transition">Program</a>
                <a href="#projects" class="hover:text-amber-400 transition">Galeri</a>
                <a href="#berita" class="hover:text-amber-400 transition">Berita</a>
            </div>
            <a href="/admin" class="bg-amber-500 text-white px-6 py-2.5 rounded text-xs font-bold uppercase tracking-wider hover:bg-amber-600 shadow-lg shadow-amber-500/30 transition">Login Admin</a>
        </div>
    </nav>

    <header class="relative h-screen min-h-[600px] flex items-center">
        <div class="absolute inset-0 z-0">
            <img src="{{ asset('images/hero.jpg') }}" loading="lazy" alt="Hero Background" class="w-full h-full object-cover">
            <div class="absolute inset-0 bg-gradient-to-r from-emerald-950/90 to-emerald-900/60"></div>
        </div>

        <div class="relative z-10 max-w-7xl mx-auto w-full px-6 pt-20">
            <h1 class="text-6xl md:text-8xl font-extrabold text-white drop-shadow-lg mb-4 tracking-tight">
                UKM PTQ
            </h1>
            
            <p class="text-xl md:text-3xl font-medium text-emerald-100 max-w-3xl leading-snug mb-10 drop-shadow-md">
                {{ $settings->site_description ?? 'UKM Terhijau di Kampus Hebat Unimal' }}
            </p>
            
            <div class="flex flex-wrap gap-4 mt-4">
                <a href="#about" class="bg-amber-500 text-emerald-950 px-8 py-4 rounded text-sm font-extrabold uppercase tracking-wider hover:bg-amber-400 transition shadow-lg shadow-amber-500/20">TENTANG KAMI</a>
                <a href="#berita" class="border-2 border-white/80 text-white px-8 py-4 rounded text-sm font-extrabold uppercase tracking-wider hover:bg-white hover:text-emerald-900 transition backdrop-blur-sm">INFO TERBARU</a>
            </div>
        </div>
    </header>

    <section id="services" class="py-24 px-6 max-w-7xl mx-auto">
        <div class="flex flex-col md:flex-row justify-between items-end mb-16">
            <div>
                <p class="text-emerald-600 font-bold uppercase tracking-widest text-xs mb-3">PROGRAM UNGGULAN</p>
                <h2 class="text-4xl font-extrabold text-gray-900">Program Kelas</h2>
            </div>
            <p class="text-gray-500 max-w-md text-sm mt-6 md:mt-0 leading-relaxed">
                Kami menawarkan berbagai program pendidikan yang disesuaikan dengan kebutuhan anggota untuk mencetak generasi yang kompeten di bidang agama dan umum.
            </p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
            @foreach($programs->take(4) as $program)
            <div class="bg-white p-8 rounded-xl shadow-sm border border-gray-100 hover:shadow-xl hover:-translate-y-1 transition duration-300 group flex flex-col h-full">
                <div class="text-emerald-600 mb-6 bg-emerald-50 w-14 h-14 flex items-center justify-center rounded-2xl group-hover:bg-emerald-600 group-hover:text-white transition">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-3">{{ $program->name }}</h3>
                <p class="text-gray-500 text-sm mb-6 leading-relaxed flex-grow">{{ \Illuminate\Support\Str::limit($program->description, 100) }}</p>
                <a href="#" class="text-emerald-700 font-bold text-xs uppercase tracking-wide group-hover:text-amber-500 transition mt-auto">Lebih Lanjut &rarr;</a>
            </div>
            @endforeach
        </div>
    </section>

    <section id="about" class="py-24 px-6 max-w-7xl mx-auto">
        <div class="flex flex-col lg:flex-row gap-16 items-center">
            <div class="w-full lg:w-1/2">
                <p class="text-emerald-600 font-bold uppercase tracking-widest text-xs mb-3">TENTANG KAMI</p>
                <h2 class="text-4xl md:text-5xl font-extrabold text-gray-900 mb-8 leading-tight">
                    Pendidikan yang indah <br>adalah sebuah <span class="text-emerald-600">Karya Seni.</span>
                </h2>
                <p class="text-gray-600 mb-6 text-base leading-relaxed">
                    Kami berkomitmen untuk menyediakan lingkungan pendidikan yang asri, nyaman, dan kondusif. Menggabungkan kurikulum modern dengan nilai-nilai kepesantrenan.
                </p>
                <p class="text-gray-600 text-base leading-relaxed">
                    Fasilitas yang memadai serta bimbingan asatidz yang berpengalaman memastikan setiap anggota mendapatkan perhatian penuh untuk menggali potensi terbaik mereka.
                </p>
            </div>
            <div class="w-full lg:w-1/2 relative">
                <div class="absolute -top-4 -left-4 w-full h-full bg-emerald-100 rounded-xl -z-10"></div>
                <img src="{{ asset('images/about.jpg') }}" loading="lazy" alt="Tentang Kami" class="rounded-xl shadow-lg w-full object-cover h-[400px]">
            </div>
        </div>
    </section>

    <section class="max-w-7xl mx-auto px-6 py-12">
        <div class="bg-emerald-800 rounded-xl p-10 lg:p-14 flex flex-col lg:flex-row justify-between items-center text-white shadow-xl relative overflow-hidden">
            <div class="absolute inset-0 opacity-10" style="background-image: radial-gradient(circle at 2px 2px, white 1px, transparent 0); background-size: 32px 32px;"></div>
            
            <div class="mb-10 lg:mb-0 w-full lg:w-1/3 relative z-10 text-center lg:text-left">
                <p class="text-emerald-300 font-bold uppercase tracking-widest text-xs mb-3">BEBERAPA ANGKA</p>
                <h2 class="text-3xl lg:text-4xl font-extrabold">Apa yang telah<br>kami capai</h2>
            </div>
            <div class="w-full lg:w-2/3 flex flex-col md:flex-row justify-between lg:justify-around gap-10 text-center relative z-10">
                <div>
                    <p class="text-5xl font-extrabold text-amber-400 mb-2">350+</p>
                    <p class="text-xs font-bold uppercase tracking-widest text-emerald-100">ANGGOTA AKTIF</p>
                </div>
                <div>
                    <p class="text-5xl font-extrabold text-amber-400 mb-2">12+</p>
                    <p class="text-xs font-bold uppercase tracking-widest text-emerald-100">TAHUN BERDIRI</p>
                </div>
                <div>
                    <p class="text-5xl font-extrabold text-amber-400 mb-2">15+</p>
                    <p class="text-xs font-bold uppercase tracking-widest text-emerald-100">PROGRAM KERJA</p>
                </div>
            </div>
        </div>
    </section>

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
                            src="{{ asset($article->cover_image) }}"
                            alt="{{ $article->title }}" 
                            loading="lazy"
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

    <section id="projects" class="py-24 px-6 max-w-7xl mx-auto">
        <div class="flex flex-col lg:flex-row gap-12 items-center">
            <div class="w-full lg:w-1/3 order-2 lg:order-1 bg-emerald-50 p-10 rounded-xl border border-emerald-100">
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
                        <img src="{{ asset('storage/' . $gallery->image_url) }}" alt="{{ $gallery->title }}" lazy="loading" onerror="this.onerror=null;this.src='https://images.unsplash.com/photo-1542838132-92c53300491e?auto=format&fit=crop&w=600&q=80';" class="w-full h-full object-cover hover:scale-110 transition duration-500">
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <footer class="bg-emerald-950 text-emerald-200 py-10 text-center text-sm border-t border-emerald-900 mt-10">
        <p>&copy; {{ date('Y') }} {{ $settings->site_name ?? 'UKM PTQ' }}. Hak Cipta Dilindungi.</p>
    </footer>

</body>
</html>