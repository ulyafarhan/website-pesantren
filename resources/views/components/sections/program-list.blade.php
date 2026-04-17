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
        <div class="relative w-full whitespace-normal break-words rounded-xl border border-blue-gray-50 bg-white p-6 font-sans shadow-lg shadow-blue-gray-500/10 transition-all duration-300 hover:shadow-xl hover:-translate-y-1">
            
            <div class="mb-3 flex items-center gap-3">
                <a href="#" class="block font-sans text-lg font-bold leading-relaxed tracking-normal text-blue-gray-900 antialiased transition-colors hover:text-emerald-600">
                    {{ $program->name }}
                </a>
                <div class="center relative inline-block select-none whitespace-nowrap rounded-full bg-emerald-500 py-1 px-2.5 align-baseline font-sans text-[10px] font-bold capitalize leading-none tracking-wide text-white">
                    <div class="mt-px">Aktif</div>
                </div>
            </div>

            <p class="block font-sans text-sm font-normal leading-relaxed text-gray-700 antialiased mb-6">
                {{ Str::limit($program->description, 120) }}
            </p>

            <div class="flex items-center gap-5 border-t border-blue-gray-50 pt-4">
                <div class="flex items-center gap-1.5">
                    <span class="h-3 w-3 rounded-full bg-blue-400"></span>
                    <p class="block font-sans text-xs font-medium text-gray-700 antialiased">
                        Kurikulum
                    </p>
                </div>

                <div class="flex items-center gap-1">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="h-4 w-4 text-emerald-500">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z" />
                    </svg>
                    <p class="block font-sans text-xs font-normal text-gray-700 antialiased">
                        120+ Santri
                    </p>
                </div>

                <div class="flex items-center gap-1 ml-auto">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="h-4 w-4 text-emerald-500">
                        <path fill-rule="evenodd" d="M8.603 3.799A4.49 4.49 0 0112 2.25c1.357 0 2.573.6 3.397 1.549a4.49 4.49 0 013.498 1.307 4.491 4.491 0 011.307 3.497A4.49 4.49 0 0121.75 12a4.49 4.49 0 01-1.549 3.397 4.491 4.491 0 01-1.307 3.497 4.491 4.491 0 01-3.497 1.307A4.49 4.49 0 0112 21.75a4.49 4.49 0 01-3.397-1.549 4.49 4.49 0 01-3.498-1.306 4.491 4.491 0 01-1.307-3.498A4.49 4.49 0 012.25 12c0-1.357.6-2.573 1.549-3.397a4.49 4.49 0 011.307-3.497 4.49 4.49 0 013.497-1.307zm7.007 6.387a.75.75 0 10-1.22-.872l-3.236 4.53L9.53 12.22a.75.75 0 00-1.06 1.06l2.25 2.25a.75.75 0 001.14-.094l3.75-5.25z" clip-rule="evenodd"></path>
                    </svg>
                    <p class="block font-sans text-[10px] font-bold uppercase text-emerald-600 antialiased">
                        Terverifikasi
                    </p>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</section>