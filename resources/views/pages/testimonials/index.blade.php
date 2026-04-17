<x-layouts.app>
    <div class="py-16 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-3xl font-extrabold text-gray-900">Apa Kata Mereka?</h2>
                <p class="mt-4 text-lg text-gray-600">Testimoni dari wali santri dan alumni Pesantren Darussa'adah.</p>
            </div>

            <div class="grid grid-cols-1 gap-8 md:grid-cols-2 lg:grid-cols-3">
                @foreach($testimonials as $testimonial)
                    <div class="bg-white p-8 rounded-3xl shadow-sm border border-gray-100">
                        <div class="flex items-center mb-4">
                            <img class="h-12 w-12 rounded-full object-cover" src="{{ asset('storage/' . $testimonial->avatar) }}" 
                                onerror="this.onerror=null; this.src='https://placehold.co/600x400?text=Gambar+Tidak+Ada';" alt="{{ $testimonial->name }}">
                            <div class="ml-4">
                                <h4 class="text-sm font-bold text-gray-900">{{ $testimonial->name }}</h4>
                                <p class="text-xs text-gray-500">{{ $testimonial->role }}</p>
                            </div>
                        </div>
                        <p class="text-gray-600 italic">"{{ $testimonial->content }}"</p>
                    </div>
                @endforeach
            </div>
            
            <div class="mt-12">
                {{ $testimonials->links() }}
            </div>
        </div>
    </div>
</x-layouts.app>