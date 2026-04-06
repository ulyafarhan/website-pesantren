@props(['testimonials'])

<section class="py-24 px-6 bg-emerald-50 relative overflow-hidden">
    <div class="absolute top-0 right-0 w-64 h-64 bg-amber-200 rounded-full mix-blend-multiply filter blur-3xl opacity-30"></div>
    
    <div class="max-w-7xl mx-auto relative z-10">
        <div class="text-center mb-16">
            <p class="text-emerald-600 font-bold uppercase tracking-widest text-xs mb-3">APA KATA MEREKA</p>
            <h2 class="text-4xl font-extrabold text-gray-900">Testimoni & Ulasan</h2>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($testimonials as $testi)
                <x-ui.card class="p-8 relative">
                    <svg class="absolute top-6 right-6 w-10 h-10 text-emerald-100" fill="currentColor" viewBox="0 0 24 24"><path d="M14.017 21v-7.391c0-5.704 3.731-9.57 8.983-10.609l.995 2.151c-2.432.917-3.995 3.638-3.995 5.849h4v10h-9.983zm-14.017 0v-7.391c0-5.704 3.748-9.57 9-10.609l.996 2.151c-2.433.917-3.996 3.638-3.996 5.849h3.983v10h-9.983z"/></svg>
                    
                    <p class="text-gray-600 italic mb-8 relative z-10">"{{ $testi->message }}"</p>
                    <div class="mt-auto">
                        <p class="font-bold text-gray-900 text-lg">{{ $testi->name }}</p>
                        <p class="text-emerald-600 text-sm font-medium">{{ $testi->role }}</p>
                    </div>
                </x-ui.card>
            @endforeach
        </div>
    </div>
</section>