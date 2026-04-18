@props(['programs'])

<section id="services" class="py-24 px-6 max-w-7xl mx-auto">
    <div class="flex flex-col md:flex-row justify-between items-end mb-16">
        <div>
            <p class="text-emerald-600 font-bold uppercase tracking-widest text-xs mb-3">PROGRAM UNGGULAN</p>
            <h2 class="text-4xl font-extrabold text-gray-900">Program Kelas</h2>
        </div>
        <p class="text-gray-500 max-w-md text-sm mt-6 md:mt-0 leading-relaxed">
            Kami menawarkan berbagai program pendidikan yang disesuaikan untuk mencetak generasi yang kompeten di bidang agama dan umum.
        </p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        @foreach($programs->take(6) as $program)
            <x-ui.program-card :program="$program" />
        @endforeach
    </div>
</section>