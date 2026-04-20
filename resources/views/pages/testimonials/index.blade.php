<x-layouts.app :settings="$settings">
    <div class="py-16 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-3xl font-extrabold text-gray-900">Apa Kata Mereka?</h2>
                <p class="mt-4 text-lg text-gray-600">Testimoni dari wali santri dan alumni Pesantren Darussaadah.</p>
            </div>

            <div class="grid grid-cols-1 gap-8 md:grid-cols-2 lg:grid-cols-3">
                @foreach($testimonials as $testimonial)
                    <div class="bg-white p-8 rounded-xl shadow-sm border border-gray-100 flex flex-col h-full">
                        <div class="flex items-center mb-6">
                            {{-- Gunakan UI Avatars sebagai fallback jika avatar kosong di database --}}
                            <img class="h-12 w-12 rounded-full object-cover border-2 border-emerald-100" 
                                 src="https://ui-avatars.com/api/?name={{ urlencode($testimonial->name) }}&background=10b981&color=fff" 
                                 alt="{{ $testimonial->name }}">
                            <div class="ml-4">
                                <h4 class="text-sm font-bold text-gray-900">{{ $testimonial->name }}</h4>
                                <p class="text-xs text-emerald-600 font-medium">{{ $testimonial->role }}</p>
                            </div>
                        </div>
                        {{-- PERBAIKAN: Gunakan 'message' sesuai DatabaseSeeder --}}
                        <p class="text-gray-600 italic leading-relaxed flex-grow">"{{ $testimonial->message }}"</p>
                    </div>
                @endforeach
            </div>
            
            <div class="mt-12">
                {{ $testimonials->links() }}
            </div>
        </div>
    </div>
</x-layouts.app>