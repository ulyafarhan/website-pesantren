@props(['program'])

<div class="relative flex flex-col h-full bg-white shadow-sm border border-slate-200 rounded w-full transition-all duration-300 hover:shadow-md hover:-translate-y-1">
    <div class="mx-3 mb-0 border-b border-slate-200 pt-3 pb-2 px-1 flex justify-between items-center">
        <span class="text-sm text-emerald-600 font-medium">
            Program Pendidikan
        </span>
        <span class="text-[10px] font-bold uppercase tracking-wider text-emerald-500 bg-emerald-50 px-2 py-1 rounded-full">
            Aktif
        </span>
    </div>
    
    <div class="p-4 flex flex-col flex-grow">
        <h5 class="mb-2 text-slate-800 text-xl font-semibold">
            {{ $program->name }}
        </h5>
        <p class="text-slate-600 leading-normal font-light flex-grow mb-5">
            {{ Str::limit($program->description, 120) }}
        </p>
        
        <div class="flex items-center justify-between pt-4 border-t border-slate-100 mt-auto">
            <div class="flex items-center gap-1.5">
                <span class="h-2 w-2 rounded-full bg-blue-400"></span>
                <span class="text-xs font-medium text-slate-600">Kurikulum</span>
            </div>
            
            <div class="flex items-center gap-1">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="h-4 w-4 text-emerald-500">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z" />
                </svg>
                <span class="text-xs font-normal text-slate-600">120+ Santri</span>
            </div>
        </div>
    </div>
</div>