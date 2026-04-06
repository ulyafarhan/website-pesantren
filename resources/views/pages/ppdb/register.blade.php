<x-layouts.app :settings="$settings" title="Pendaftaran Santri Baru">
    <div class="max-w-4xl mx-auto px-6 py-12">
        
        <div class="text-center mb-12">
            <x-ui.badge color="amber" class="mb-4 text-sm px-4">PPDB ONLINE</x-ui.badge>
            <h1 class="text-4xl font-extrabold text-gray-900 mb-2">Formulir Pendaftaran</h1>
            <p class="text-gray-600 font-medium">Gelombang: <span class="text-emerald-700 font-bold">{{ $period->name }}</span></p>
        </div>

        <x-ui.card class="p-8 md:p-12 shadow-xl border-emerald-100 relative overflow-hidden">
            <div class="absolute top-0 right-0 w-32 h-32 bg-emerald-50 rounded-bl-full -z-10"></div>

            <form action="{{ url('/api/v1/register') }}" method="POST" enctype="multipart/form-data" class="space-y-10 relative z-10" id="ppdbForm">
                @csrf
                
                <div>
                    <h3 class="text-xl font-bold text-gray-900 mb-6 pb-2 border-b border-gray-100 flex items-center gap-2">
                        <svg class="w-6 h-6 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                        Identitas Santri
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="md:col-span-2">
                            <x-forms.label>Nama Lengkap (Sesuai Akta) <span class="text-red-500">*</span></x-forms.label>
                            <x-forms.input name="full_name" type="text" placeholder="Masukkan nama lengkap" required />
                        </div>
                        </div>
                </div>

                @if($period->form_schema && count($period->form_schema) > 0)
                <div>
                    <h3 class="text-xl font-bold text-gray-900 mb-6 pb-2 border-b border-gray-100 flex items-center gap-2">
                        <svg class="w-6 h-6 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                        Data Tambahan
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        @foreach($period->form_schema as $field)
                            <div class="{{ $field['type'] === 'textarea' ? 'md:col-span-2' : '' }}">
                                <x-forms.label>{{ $field['label'] }} {!! $field['is_required'] ? '<span class="text-red-500">*</span>' : '' !!}</x-forms.label>
                                
                                @if($field['type'] === 'textarea')
                                    <x-forms.textarea name="data[{{ $field['field_name'] }}]" rows="3" {{ $field['is_required'] ? 'required' : '' }}></x-forms.textarea>
                                @elseif($field['type'] === 'select')
                                    <x-forms.select name="data[{{ $field['field_name'] }}]" {{ $field['is_required'] ? 'required' : '' }}>
                                        <option value="">Pilih opsi...</option>
                                        </x-forms.select>
                                @else
                                    <x-forms.input type="{{ $field['type'] === 'date' ? 'date' : ($field['type'] === 'number' ? 'number' : 'text') }}" name="data[{{ $field['field_name'] }}]" {{ $field['is_required'] ? 'required' : '' }} />
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>
                @endif

                @if($period->document_schema && count($period->document_schema) > 0)
                <div>
                    <h3 class="text-xl font-bold text-gray-900 mb-6 pb-2 border-b border-gray-100 flex items-center gap-2">
                        <svg class="w-6 h-6 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path></svg>
                        Unggah Berkas Pendukung
                    </h3>
                    <div class="space-y-5 bg-amber-50/50 p-6 rounded-2xl border border-amber-100">
                        <p class="text-sm text-amber-800 mb-4 font-medium flex items-center gap-2">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path></svg>
                            Berkas wajib format PDF/JPG/PNG. Maksimal 2MB.
                        </p>
                        @foreach($period->document_schema as $doc)
                            <div>
                                <x-forms.label>{{ $doc['label'] }} {!! $doc['is_required'] ? '<span class="text-red-500">*</span>' : '' !!}</x-forms.label>
                                <x-forms.file-upload name="documents[{{ $doc['document_key'] }}]" accept=".pdf,.jpg,.jpeg,.png" {{ $doc['is_required'] ? 'required' : '' }} />
                            </div>
                        @endforeach
                    </div>
                </div>
                @endif

                <div class="pt-6 border-t border-gray-100 flex justify-end">
                    <x-ui.button type="submit" variant="primary" class="w-full md:w-auto px-10 text-lg py-4">Kirim Pendaftaran &rarr;</x-ui.button>
                </div>
            </form>
        </x-ui.card>
    </div>

    <script>
        document.getElementById('ppdbForm').addEventListener('submit', async function(e) {
            e.preventDefault();
            const btn = this.querySelector('button[type="submit"]');
            const originalText = btn.innerHTML;
            btn.innerHTML = 'Mengirim...';
            btn.disabled = true;

            try {
                const formData = new FormData(this);
                const response = await fetch(this.action, {
                    method: 'POST',
                    headers: { 'Accept': 'application/json' },
                    body: formData
                });
                
                const data = await response.json();
                
                if (response.ok) {
                    // Redirect ke halaman sukses membawa no. registrasi
                    window.location.href = `/ppdb/success?reg=${data.registration_number}`;
                } else {
                    alert('Gagal: ' + (data.message || 'Periksa kembali isian Anda.'));
                    btn.innerHTML = originalText;
                    btn.disabled = false;
                }
            } catch (err) {
                alert('Terjadi kesalahan sistem.');
                btn.innerHTML = originalText;
                btn.disabled = false;
            }
        });
    </script>
</x-layouts.app>