<?php

namespace App\Filament\Resources\Registrations\Schemas;

use Filament\Schemas\Schema;
use Filament\Schemas\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\KeyValue;
use Filament\Forms\Components\FileUpload;
use Illuminate\Support\Str;

class RegistrationForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                // SEKSI 1: IDENTITAS UTAMA
                Section::make('Identitas Calon Santri')
                    ->description('Data primer sesuai dokumen kependudukan resmi (KK/Akta).')
                    ->icon('heroicon-m-user')
                    ->schema([
                        TextInput::make('full_name')
                            ->label('Nama Lengkap')
                            ->placeholder('Masukkan nama lengkap sesuai ijazah/akta')
                            ->required()
                            ->maxLength(255)
                            ->columnSpanFull(),

                        TextInput::make('nik')
                            ->label('NIK')
                            ->placeholder('16 digit NIK')
                            ->maxLength(16)
                            ->rule('digits:16')
                            ->tel()
                            ->required()
                            ->columnSpanFull(),

                        Select::make('gender')
                            ->label('Jenis Kelamin')
                            ->options([
                                'L' => 'Laki-laki',
                                'P' => 'Perempuan'
                            ])
                            ->required()
                            ->native(false)
                            ->columnSpanFull(),

                        TextInput::make('place_of_birth')
                            ->label('Tempat Lahir')
                            ->required()
                            ->columnSpanFull(),
                        
                        DatePicker::make('date_of_birth')
                            ->label('Tanggal Lahir')
                            ->displayFormat('d F Y')
                            ->native(false)
                            ->required()
                            ->columnSpanFull(),
                    ]),

                // SEKSI 2: ADMINISTRASI & KONTAK
                Section::make('Status Administrasi & Kontak')
                    ->description('Informasi gelombang pendaftaran dan kontak orang tua.')
                    ->icon('heroicon-m-arrow-path')
                    ->schema([
                        TextInput::make('registration_number')
                            ->label('No. Registrasi')
                            ->default(fn () => 'REG-' . now()->format('Ymd') . strtoupper(Str::random(4)))
                            ->readonly()
                            ->helperText('Nomor ini digenerate otomatis dan tidak dapat diubah.')
                            ->columnSpanFull(),

                        Select::make('registration_period_id')
                            ->label('Gelombang Pendaftaran')
                            ->relationship('period', 'name')
                            ->searchable()
                            ->preload()
                            ->required()
                            ->columnSpanFull(),

                        Select::make('status')
                            ->label('Status Seleksi Saat Ini')
                            ->options([
                                'PENDING' => 'Menunggu Verifikasi',
                                'VERIFIED' => 'Berkas Valid',
                                'TESTING' => 'Tahap Seleksi',
                                'ACCEPTED' => 'Lulus / Diterima',
                                'REJECTED' => 'Tidak Lulus',
                                'REGISTERED' => 'Daftar Ulang Selesai',
                            ])
                            ->required()
                            ->native(false)
                            ->columnSpanFull(),

                        TextInput::make('phone_number')
                            ->label('Nomor WhatsApp (Orang Tua)')
                            ->tel()
                            ->prefix('+62')
                            ->placeholder('81234567xxx')
                            ->required()
                            ->columnSpanFull(),
                    ]),

                // SEKSI 3: SELEKSI (KHUSUS ADMIN)
                Section::make('Hasil Seleksi & Verifikasi')
                    ->description('Bagian ini diisi oleh panitia setelah proses ujian/wawancara.')
                    ->icon('heroicon-m-clipboard-document-check')
                    ->collapsible()
                    ->schema([
                        TextInput::make('test_score')
                            ->label('Nilai Skor Seleksi')
                            ->numeric()
                            ->minValue(0)
                            ->maxValue(100)
                            ->placeholder('0-100')
                            ->columnSpanFull(),
                        
                        Select::make('verified_by')
                            ->label('Petugas Verifikator')
                            ->relationship('verifiedBy', 'name')
                            ->searchable()
                            ->preload()
                            ->columnSpanFull(),
                            
                        Textarea::make('admin_notes')
                            ->label('Catatan Panitia / Alasan Penolakan')
                            ->placeholder('Tuliskan catatan khusus mengenai calon santri di sini...')
                            ->rows(3)
                            ->columnSpanFull(),
                    ]),

                // SEKSI 4: BERKAS & DATA DINAMIS
                Section::make('Berkas & Data Tambahan')
                    ->description('Unggahan dokumen pendukung dan isian formulir dinamis tahunan.')
                    ->icon('heroicon-m-document-arrow-up')
                    ->collapsible()
                    ->schema([
                        KeyValue::make('data')
                            ->label('Informasi Tambahan (Form Dinamis)')
                            ->keyLabel('Kategori Data')
                            ->valueLabel('Isian/Jawaban')
                            ->columnSpanFull(),

                        FileUpload::make('documents')
                            ->label('Unggah Berkas Pendukung')
                            ->helperText('Unggah Scan KK, Akta, atau Ijazah (Max: 2MB per file)')
                            ->multiple()
                            ->directory('registrations/documents')
                            ->preserveFilenames()
                            ->columnSpanFull(),
                    ]),
            ]);
    }
}