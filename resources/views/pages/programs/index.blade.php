<x-layouts.app :settings="$settings">
    <section class="py-20 px-6 max-w-7xl mx-auto">
        <div class="text-center mb-16">
            <p class="text-emerald-600 font-bold uppercase tracking-widest text-xs mb-3">PENDIDIKAN TERPADU</p>
            <h1 class="text-4xl font-black text-gray-900 mb-4">Seluruh Program Pendidikan</h1>
            <p class="text-gray-500 max-w-2xl mx-auto">Kurikulum terintegrasi yang menggabungkan nilai keislaman dan sains modern untuk mencetak santri unggulan.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($programs as $program)
                {{-- Panggil komponen card di sini --}}
                <x-ui.program-card :program="$program" />
            @endforeach
        </div>
    </section>
</x-layouts.app>