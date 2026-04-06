<x-layouts.app :settings="$settings" title="Program Kelas">
    <div class="pt-32 pb-12 px-6 bg-emerald-950 text-white">
        <div class="max-w-7xl mx-auto">
            <x-navigations.breadcrumb :items="['Program Kelas' => null]" />
            <h1 class="text-4xl md:text-5xl font-extrabold mb-4">Program Kelas & Akademik</h1>
            <p class="text-emerald-200">Pilihan program unggulan untuk mencetak generasi yang kompeten.</p>
        </div>
    </div>

    <x-sections.program-list :programs="$programs" />
</x-layouts.app>