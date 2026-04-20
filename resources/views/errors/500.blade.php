<x-layouts.app>
    <div class="flex flex-col items-center justify-center min-h-[60vh] px-4 py-16 text-center">
        <h1 class="text-7xl font-extrabold text-rose-600">500</h1>
        <h2 class="mt-4 text-2xl font-bold text-gray-800">Gangguan Sistem</h2>
        <p class="mt-2 text-gray-600">Mohon maaf, server kami sedang mengalami gangguan. Tim IT kami sedang memperbaikinya.</p>
        
        <a href="{{ route('home') }}" class="px-6 py-3 mt-8 font-semibold text-white transition-colors bg-gray-800 rounded hover:bg-gray-900">
            Coba Muat Ulang Beranda
        </a>
    </div>
</x-layouts.app>