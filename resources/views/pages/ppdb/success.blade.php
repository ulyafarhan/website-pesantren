<x-layouts.blank title="Pendaftaran Berhasil">
    <div class="bg-white p-10 md:p-14 rounded-[2.5rem] shadow-2xl text-center border border-gray-100 relative overflow-hidden">
        <div class="absolute inset-0 bg-emerald-50 opacity-50" style="background-image: radial-gradient(#10b981 1px, transparent 1px); background-size: 20px 20px;"></div>
        
        <div class="relative z-10">
            <div class="w-24 h-24 bg-emerald-100 text-emerald-600 rounded-full flex items-center justify-center mx-auto mb-8 shadow-inner">
                <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
            </div>
            
            <h1 class="text-3xl font-extrabold text-gray-900 mb-4">Pendaftaran Berhasil!</h1>
            <p class="text-gray-600 mb-8">Terima kasih telah mendaftar. Simpan nomor registrasi Anda di bawah ini dengan baik untuk mengecek status seleksi.</p>
            
            <div class="bg-emerald-900 text-amber-400 py-4 px-6 rounded-2xl mb-10 shadow-lg inline-block border-2 border-emerald-800">
                <p class="text-xs text-emerald-300 font-bold uppercase tracking-widest mb-1">Nomor Registrasi Anda</p>
                <p class="text-3xl font-mono font-bold tracking-wider" id="regNumber">REG-LOADING</p>
            </div>

            <div class="flex flex-col gap-3">
                <x-ui.button variant="primary" href="{{ route('home') }}">Kembali ke Beranda</x-ui.button>
                <button onclick="window.print()" class="text-sm font-bold text-gray-500 hover:text-emerald-700 transition underline">Cetak / Simpan PDF</button>
            </div>
        </div>
    </div>

    <script>
        const urlParams = new URLSearchParams(window.location.search);
        const reg = urlParams.get('reg');
        if(reg) document.getElementById('regNumber').innerText = reg;
    </script>
</x-layouts.blank>