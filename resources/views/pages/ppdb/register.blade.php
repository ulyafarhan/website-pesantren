<x-layouts.app :settings="$settings">
    <div class="max-w-4xl mx-auto px-6 py-12">
        {{-- Header Form --}}
        <div class="mb-10 text-center">
            <h1 class="text-3xl font-extrabold text-gray-900 mb-2">Formulir Pendaftaran Santri Baru</h1>
            <p class="text-gray-500 italic">{{ $period->name }}</p>
            <div class="h-1 w-20 bg-emerald-600 mx-auto mt-4 rounded-full"></div>
        </div>

        <form action="{{ route('ppdb.store') }}" method="POST" enctype="multipart/form-data" class="space-y-12">
            @csrf

            {{-- SEKSI 1: IDENTITAS INTI --}}
            <section class="bg-white p-8 rounded border border-slate-200 shadow-sm relative overflow-hidden">
                <div class="absolute top-0 left-0 w-1.5 h-full bg-emerald-600"></div>
                <h2 class="text-xl font-bold text-gray-800 mb-6 flex items-center gap-2">
                    <span class="bg-emerald-100 text-emerald-700 w-8 h-8 rounded-full flex items-center justify-center text-sm">1</span>
                    Identitas Calon Santri
                </h2>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="md:col-span-2">
                        <x-forms.label for="full_name">Nama Lengkap Sesuai Ijazah/AKTA</x-forms.label>
                        <x-forms.input name="full_name" id="full_name" placeholder="Contoh: Muhammad Ulya Farhan" required />
                        <x-forms.error name="full_name" />
                    </div>

                    <div>
                        <x-forms.label for="nik">NIK (Nomor Induk Kependudukan)</x-forms.label>
                        <x-forms.input name="nik" id="nik" type="number" placeholder="16 Digit NIK" required />
                        <x-forms.error name="nik" />
                    </div>

                    <div>
                        <x-forms.label for="gender">Jenis Kelamin</x-forms.label>
                        <x-forms.select name="gender" id="gender" required>
                            <option value="">Pilih Jenis Kelamin</option>
                            <option value="L">Laki-laki</option>
                            <option value="P">Perempuan</option>
                        </x-forms.select>
                        <x-forms.error name="gender" />
                    </div>

                    <div>
                        <x-forms.label for="place_of_birth">Tempat Lahir</x-forms.label>
                        <x-forms.input name="place_of_birth" id="place_of_birth" placeholder="Contoh: Sigli" required />
                    </div>

                    <div>
                        <x-forms.label for="date_of_birth">Tanggal Lahir</x-forms.label>
                        <x-forms.input name="date_of_birth" id="date_of_birth" type="date" required />
                    </div>

                    <div class="md:col-span-2">
                        <x-forms.label for="phone_number">Nomor WhatsApp Orang Tua (Aktif)</x-forms.label>
                        <x-forms.input name="phone_number" id="phone_number" type="tel" placeholder="08xxxxxxxxxx" required />
                        <p class="text-[10px] text-gray-400 mt-1">*Segala informasi pendaftaran akan dikirim ke nomor ini.</p>
                    </div>
                </div>
            </section>

            {{-- SEKSI 2: DATA DINAMIS (Berdasarkan Schema Database) --}}
            @if($period->form_schema)
            <section class="bg-white p-8 rounded border border-slate-200 shadow-sm relative overflow-hidden">
                <div class="absolute top-0 left-0 w-1.5 h-full bg-amber-500"></div>
                <h2 class="text-xl font-bold text-gray-800 mb-6 flex items-center gap-2">
                    <span class="bg-amber-100 text-amber-700 w-8 h-8 rounded-full flex items-center justify-center text-sm">2</span>
                    Informasi Tambahan & Keluarga
                </h2>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    @foreach($period->form_schema as $field)
                        <div class="{{ $field['type'] === 'textarea' ? 'md:col-span-2' : '' }}">
                            <x-forms.label :for="'data.'.$field['field_name']">
                                {{ $field['label'] }} {!! $field['is_required'] ? '<span class="text-red-500">*</span>' : '' !!}
                            </x-forms.label>

                            @if($field['type'] === 'textarea')
                                <x-forms.textarea name="data[{{ $field['field_name'] }}]" :id="'data.'.$field['field_name']" :required="$field['is_required']" rows="3" />
                            @else
                                <x-forms.input :type="$field['type']" name="data[{{ $field['field_name'] }}]" :id="'data.'.$field['field_name']" :required="$field['is_required']" />
                            @endif
                        </div>
                    @endforeach
                </div>
            </section>
            @endif

            {{-- SEKSI 3: UPLOAD DOKUMEN --}}
            @if($period->document_schema)
            <section class="bg-white p-8 rounded border border-slate-200 shadow-sm relative overflow-hidden">
                <div class="absolute top-0 left-0 w-1.5 h-full bg-blue-500"></div>
                <h2 class="text-xl font-bold text-gray-800 mb-6 flex items-center gap-2">
                    <span class="bg-blue-100 text-blue-700 w-8 h-8 rounded-full flex items-center justify-center text-sm">3</span>
                    Unggah Berkas Pendukung
                </h2>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    @foreach($period->document_schema as $doc)
                        <div class="p-4 rounded border border-dashed border-slate-300 hover:border-emerald-400 transition-colors">
                            <x-forms.label :for="'docs.'.$doc['document_key']" class="mb-3 block font-bold">
                                {{ $doc['label'] }} {!! $doc['is_required'] ? '<span class="text-red-500">*</span>' : '' !!}
                            </x-forms.label>
                            <x-forms.file-upload name="documents[{{ $doc['document_key'] }}]" :id="'docs.'.$doc['document_key']" :required="$doc['is_required']" />
                            <p class="text-[10px] text-gray-400 mt-2">Format: JPG, PNG, PDF (Maks. 2MB)</p>
                        </div>
                    @endforeach
                </div>
            </section>
            @endif

            {{-- Tombol Submit --}}
            <div class="flex flex-col items-center gap-4 pt-6">
                <button type="submit" class="w-full md:w-auto px-12 py-4 bg-emerald-600 hover:bg-emerald-700 text-white font-extrabold rounded shadow-xl shadow-emerald-200 transition-all transform hover:-translate-y-1 active:scale-95">
                    KIRIM PENDAFTARAN SEKARANG
                </button>
                <p class="text-xs text-gray-400 text-center">Dengan menekan tombol di atas, Anda menyatakan bahwa data yang diisi adalah benar dan dapat dipertanggungjawabkan.</p>
            </div>
        </form>
    </div>
</x-layouts.app>