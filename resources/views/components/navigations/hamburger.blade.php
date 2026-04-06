<button @click="mobileMenuOpen = !mobileMenuOpen" type="button" 
        class="lg:hidden relative z-50 inline-flex items-center justify-center p-2 rounded-md text-emerald-100 hover:text-white hover:bg-emerald-800/50 focus:outline-none transition-colors duration-200"
        aria-label="Toggle menu">
    <svg x-show="!mobileMenuOpen" class="h-7 w-7 transform transition-transform duration-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 6h16M4 12h16m-7 6h7" />
    </svg>
    <svg x-show="mobileMenuOpen" x-cloak class="h-7 w-7 transform transition-transform duration-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12" />
    </svg>
</button>