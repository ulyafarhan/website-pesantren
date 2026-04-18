@props(['settings'])

<footer class="bg-emerald-950 text-emerald-200 border-t border-emerald-900 mt-20 relative z-10">
    <div class="max-w-7xl mx-auto px-6 py-16 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-12">
        <div class="lg:col-span-2">
            <div class="flex items-center gap-2 mb-4">
                <svg class="w-8 h-8 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                {{-- PERBAIKAN: Menyesuaikan properti dengan struktur database (name, bukan site_name) --}}
                <h3 class="text-white font-extrabold text-2xl tracking-tight">{{ $settings->name ?? 'Pesantren Darussaadah' }}</h3>
            </div>
            {{-- PERBAIKAN: Menyesuaikan properti dengan struktur database (description) --}}
            <p class="text-sm leading-relaxed mb-8 pr-0 lg:pr-10">{{ $settings->description ?? 'Mencetak generasi cerdas dan berakhlak mulia untuk membangun peradaban dunia yang lebih baik.' }}</p>
            <div class="flex gap-4">
                {{-- Sosial Media: Biarkan menggunakan target="_blank" dan JANGAN gunakan wire:navigate --}}
                @if($settings->facebook_url) <a href="{{ $settings->facebook_url }}" target="_blank" rel="noopener noreferrer" class="bg-emerald-900 p-3 rounded-full hover:bg-amber-500 hover:text-emerald-950 transition"><svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z"/></svg></a> @endif
                @if($settings->instagram_url) <a href="{{ $settings->instagram_url }}" target="_blank" rel="noopener noreferrer" class="bg-emerald-900 p-3 rounded-full hover:bg-amber-500 hover:text-emerald-950 transition"><svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zM12 0C8.741 0 8.333.014 7.053.072 2.695.272.273 2.69.073 7.052.014 8.333 0 8.741 0 12c0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98C8.333 23.986 8.741 24 12 24c3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98C15.668.014 15.259 0 12 0zm0 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zM12 16a4 4 0 110-8 4 4 0 010 8zm6.406-11.845a1.44 1.44 0 100 2.881 1.44 1.44 0 000-2.881z"/></svg></a> @endif
                @if($settings->youtube_url) <a href="{{ $settings->youtube_url }}" target="_blank" rel="noopener noreferrer" class="bg-emerald-900 p-3 rounded-full hover:bg-amber-500 hover:text-emerald-950 transition"><svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/></svg></a> @endif
            </div>
        </div>
        
        <div>
            <h4 class="text-white font-bold mb-6 uppercase tracking-widest text-xs">Jelajahi</h4>
            <ul class="space-y-3 text-sm">
                {{-- PERBAIKAN: Menambahkan wire:navigate --}}
                <li><a href="{{ route('home') }}" wire:navigate class="hover:text-amber-400 transition flex items-center gap-2">&rarr; Beranda</a></li>
                <li><a href="{{ route('programs.index') }}" wire:navigate class="hover:text-amber-400 transition flex items-center gap-2">&rarr; Program Kelas</a></li>
                <li><a href="{{ route('facilities.index') }}" wire:navigate class="hover:text-amber-400 transition flex items-center gap-2">&rarr; Fasilitas</a></li>
                <li><a href="{{ route('galleries.index') }}" wire:navigate class="hover:text-amber-400 transition flex items-center gap-2">&rarr; Galeri</a></li>
                <li><a href="{{ route('articles.index') }}" wire:navigate class="hover:text-amber-400 transition flex items-center gap-2">&rarr; Berita & Artikel</a></li>
            </ul>
        </div>
        
        <div>
            <h4 class="text-white font-bold mb-6 uppercase tracking-widest text-xs">Kontak</h4>
            <ul class="space-y-4 text-sm">
                <li class="flex items-start gap-3">
                    <svg class="w-5 h-5 text-emerald-500 mt-0.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                    <span>{{ $settings->address ?? 'Alamat Belum Diatur' }}</span>
                </li>
                {{-- Email & Telepon: Tidak menggunakan wire:navigate karena memanggil aplikasi eksternal --}}
                <li class="flex items-center gap-3">
                    <svg class="w-5 h-5 text-emerald-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                    <a href="mailto:{{ $settings->email }}" class="hover:text-white transition">{{ $settings->email ?? '-' }}</a>
                </li>
                <li class="flex items-center gap-3">
                    <svg class="w-5 h-5 text-emerald-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                    <span>{{ $settings->phone ?? '-' }}</span>
                </li>
            </ul>
        </div>
    </div>
    
    <div class="border-t border-emerald-900 py-6">
        <div class="max-w-7xl mx-auto px-6 flex flex-col md:flex-row justify-between items-center text-xs text-emerald-400 gap-4">
            <p>&copy; {{ date('Y') }} {{ $settings->name ?? 'Pesantren Darussaadah' }}. Hak Cipta Dilindungi.</p>
            <div class="flex gap-4">
                {{-- PERBAIKAN: Menambahkan wire:navigate pada PPDB --}}
                <a href="{{ route('ppdb.register') }}" wire:navigate class="hover:text-white transition">Pendaftaran PPDB</a>
                <span>|</span>
                
                {{-- PERHATIAN: Admin portal SANGAT DILARANG menggunakan wire:navigate.
                     Filament CMS memerlukan hard-reload agar aset JavaScript admin-nya termuat dengan benar. --}}
                <a href="/admin" class="hover:text-white transition">Portal Admin</a>
            </div>
        </div>
    </div>
</footer>