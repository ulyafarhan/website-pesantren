<x-layouts.app>
    <div class="flex flex-col items-center justify-center min-h-[60vh] px-4 py-16 text-center">
        <h1 class="text-7xl font-extrabold text-emerald-600">404</h1>
        <h2 class="mt-4 text-2xl font-bold text-gray-800">Halaman Tidak Ditemukan</h2>
        <p class="mt-2 text-gray-600">Maaf, halaman yang Anda cari mungkin telah dihapus atau URL-nya salah.</p>
        
        <a href="{{ route('home') }}" class="px-6 py-3 mt-8 font-semibold text-white transition-colors rounded bg-emerald-600 hover:bg-emerald-700">
            Kembali ke Beranda
        </a>
    </div>
</x-layouts.app>