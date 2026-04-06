@props(['name', 'title'])

<div x-data="{ show: false }" 
     x-show="show" 
     @open-modal.window="if ($event.detail === '{{ $name }}') show = true"
     @close-modal.window="if ($event.detail === '{{ $name }}') show = false"
     @keydown.escape.window="show = false"
     class="fixed inset-0 z-[100] flex items-center justify-center overflow-y-auto px-4 py-6 sm:px-0"
     style="display: none;">
    
    <div x-show="show" x-transition.opacity class="fixed inset-0 bg-emerald-950/70 backdrop-blur-sm" @click="show = false"></div>

    <div x-show="show" x-transition.scale class="bg-white rounded-3xl overflow-hidden shadow-2xl transform transition-all sm:w-full sm:max-w-2xl relative z-10">
        <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center">
            <h3 class="text-xl font-extrabold text-gray-900">{{ $title }}</h3>
            <button @click="show = false" class="text-gray-400 hover:text-red-500 transition">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>
        <div class="p-6 text-gray-600">
            {{ $slot }}
        </div>
    </div>
</div>