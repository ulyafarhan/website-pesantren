<section class="max-w-7xl mx-auto px-6 py-12" 
         x-data="{ 
            animateCount(target, duration) {
                let start = 0;
                const end = parseInt(target);
                const range = end - start;
                let startTime = null;

                const step = (timestamp) => {
                    if (!startTime) startTime = timestamp;
                    const progress = Math.min((timestamp - startTime) / duration, 1);
                    // Easing function: easeOutExpo untuk pergerakan yang elegan
                    const value = Math.floor(progress === 1 ? end : end * (1 - Math.pow(2, -10 * progress)));
                    this.currentValue = value;
                    if (progress < 1) {
                        window.requestAnimationFrame(step);
                    }
                };
                window.requestAnimationFrame(step);
            }
         }">
    
    <div class="bg-emerald-800 rounded p-10 lg:p-14 flex flex-col lg:flex-row justify-between items-center text-white shadow-xl relative overflow-hidden">
        {{-- Pola Background --}}
        <div class="absolute inset-0 opacity-10" style="background-image: radial-gradient(circle at 2px 2px, white 1px, transparent 0); background-size: 32px 32px;"></div>
        
        <div class="mb-10 lg:mb-0 w-full lg:w-1/3 relative z-10 text-center lg:text-left">
            <p class="text-emerald-300 font-bold uppercase tracking-widest text-xs mb-3">BEBERAPA ANGKA</p>
            <h2 class="text-3xl lg:text-4xl font-extrabold">Apa yang telah<br>kami capai</h2>
        </div>

        <div class="w-full lg:w-2/3 flex flex-col md:flex-row justify-between lg:justify-around gap-10 text-center relative z-10">
            
            {{-- Angka 1: Anggota Aktif --}}
            <div x-data="{ current: 0, target: 999 }" 
                 x-intersect.once="animateValue($el, 0, target, 2000)">
                <p class="text-5xl font-extrabold text-amber-400 mb-2">
                    <span x-text="current">0</span>+
                </p>
                <p class="text-xs font-bold uppercase tracking-widest text-emerald-100">ANGGOTA AKTIF</p>
            </div>

            {{-- Angka 2: Tahun Berdiri --}}
            <div x-data="{ current: 0, target:50 }" 
                 x-intersect.once="animateValue($el, 0, target, 2500)">
                <p class="text-5xl font-extrabold text-amber-400 mb-2">
                    <span x-text="current">0</span>+
                </p>
                <p class="text-xs font-bold uppercase tracking-widest text-emerald-100">TAHUN BERDIRI</p>
            </div>

            {{-- Angka 3: Program Kerja --}}
            <div x-data="{ current: 0, target: 15 }" 
                 x-intersect.once="animateValue($el, 0, target, 2000)">
                <p class="text-5xl font-extrabold text-amber-400 mb-2">
                    <span x-text="current">0</span>+
                </p>
                <p class="text-xs font-bold uppercase tracking-widest text-emerald-100">PROGRAM KERJA</p>
            </div>

        </div>
    </div>
</section>

<script>
    /**
     * Fungsi Helper Global untuk animasi counter
     * Menggunakan requestAnimationFrame untuk performa maksimal di HP
     */
    function animateValue(container, start, end, duration) {
        let startTimestamp = null;
        const step = (timestamp) => {
            if (!startTimestamp) startTimestamp = timestamp;
            const progress = Math.min((timestamp - startTimestamp) / duration, 1);
            
            const currentVal = Math.floor(progress * (end - start) + start);
            
            container._x_dataStack[0].current = currentVal;

            if (progress < 1) {
                window.requestAnimationFrame(step);
            }
        };
        window.requestAnimationFrame(step);
    }
</script>