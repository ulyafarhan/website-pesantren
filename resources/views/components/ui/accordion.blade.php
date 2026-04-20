@props(['title'])

<div x-data="{ open: false }" class="border border-gray-200 rounded-lg mb-4 overflow-hidden bg-white">
    <button @click="open = !open" class="w-full flex justify-between items-center p-5 text-left focus:outline-none hover:bg-gray-50 transition">
        <span class="font-bold text-gray-900">{{ $title }}</span>
        <svg class="w-5 h-5 text-emerald-600 transform transition-transform duration-300" :class="{'rotate-180': open}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
    </button>
    <div x-show="open" x-collapse x-cloak class="p-5 pt-0 text-gray-600 text-sm leading-relaxed border-t border-gray-100">
        {{ $slot }}
    </div>
</div>