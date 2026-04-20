<x-layouts.app :settings="$settings" title="Cek Status Pendaftaran">
    <div class="pt-32 pb-12 px-6 bg-emerald-950 text-white relative">
        <div class="absolute inset-0 bg-[url('https://www.transparenttextures.com/patterns/cubes.png')] opacity-10"></div>
        <div class="max-w-xl mx-auto text-center relative z-10">
            <h1 class="text-4xl md:text-5xl font-extrabold mb-4">Cek Status</h1>
            <p class="text-emerald-200">Pantau proses seleksi pendaftaran Anda.</p>
        </div>
    </div>
    
    <section class="py-16 px-6 max-w-xl mx-auto -mt-10 relative z-20">
        <x-ui.card class="p-8 md:p-12 shadow-xl border-0">
            <form action="{{ route('ppdb.check') ?? '#' }}" method="GET" class="space-y-6">
                <div>
                    <x-forms.label for="registration_number" value="Masukkan Nomor Pendaftaran" />
                    <x-forms.input id="registration_number" type="text" name="registration_number" value="{{ request('registration_number') }}" placeholder="Contoh: REG-20260101ABCD" required autofocus class="text-center text-lg font-bold tracking-widest" />
                </div>
                <x-ui.button type="submit" class="w-full py-4">Periksa Status</x-ui.button>
            </form>

            @if(isset($registration))
                <div class="mt-12 pt-8 border-t border-gray-100">
                    <div class="flex items-center gap-3 mb-6">
                        <svg class="w-6 h-6 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        <h3 class="text-lg font-extrabold text-gray-900">Hasil Pencarian</h3>
                    </div>
                    
                    <div class="space-y-4 text-sm bg-gray-50 p-6 rounded">
                        <div class="flex justify-between items-center border-b border-gray-200 pb-3">
                            <span class="text-gray-500 font-medium">Nama Lengkap</span>
                            <span class="font-bold text-gray-900">{{ $registration->full_name }}</span>
                        </div>
                        <div class="flex justify-between items-center border-b border-gray-200 pb-3">
                            <span class="text-gray-500 font-medium">Gelombang</span>
                            <span class="font-bold text-gray-900">{{ $registration->period->name ?? '-' }}</span>
                        </div>
                        <div class="flex justify-between items-center pt-1">
                            <span class="text-gray-500 font-medium">Status Saat Ini</span>
                            @php
                                $statusColors = [
                                    'PENDING' => 'bg-gray-100 text-gray-800',
                                    'VERIFIED' => 'bg-blue-100 text-blue-800',
                                    'TESTING' => 'bg-amber-100 text-amber-800',
                                    'ACCEPTED' => 'bg-emerald-100 text-emerald-800',
                                    'REJECTED' => 'bg-red-100 text-red-800',
                                    'REGISTERED' => 'bg-emerald-100 text-emerald-800',
                                ];
                                $color = $statusColors[$registration->status] ?? 'bg-gray-100 text-gray-800';
                            @endphp
                            <span class="px-4 py-1.5 rounded-full text-xs font-extrabold tracking-wider uppercase shadow-sm {{ $color }}">
                                {{ $registration->status }}
                            </span>
                        </div>
                    </div>
                </div>
            @elseif(request()->has('registration_number'))
                <div class="mt-8">
                    <x-ui.alert type="error">
                        <strong>Data Tidak Ditemukan!</strong><br>
                        Pastikan nomor pendaftaran yang Anda masukkan sudah benar dan sesuai dengan format.
                    </x-ui.alert>
                </div>
            @endif
        </x-ui.card>
    </section>
</x-layouts.app>