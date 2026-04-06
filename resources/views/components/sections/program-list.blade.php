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
            <div class="bg-white p-8 rounded-3xl shadow-sm border border-gray-100 hover:shadow-xl hover:-translate-y-1 transition duration-300 group flex flex-col h-full">
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