<?php

namespace App\Filament\Resources\RegistrationPeriods\Schemas;

use Filament\Schemas\Schema;
use Filament\Schemas\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;

class RegistrationPeriodForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Informasi Periode')
                    ->description('Atur nama gelombang dan status aktif pendaftaran.')
                    ->icon('heroicon-m-calendar-days')
                    ->schema([
                        TextInput::make('name')
                            ->label('Nama Gelombang')
                            ->placeholder('Contoh: Gelombang 1 - Tahun Ajaran 2026/2027')
                            ->required()
                            ->maxLength(255),
                        
                        Toggle::make('is_active')
                            ->label('Buka Pendaftaran?')
                            ->helperText('Jika aktif, formulir ini akan muncul di halaman pendaftaran publik.'),
                    ]),
                
                Section::make('Konfigurasi Formulir Dinamis')
                    ->description('Tentukan kolom isian tambahan yang harus diisi santri.')
                    ->icon('heroicon-m-list-bullet')
                    ->schema([
                        Repeater::make('form_schema')
                            ->label('Kolom Isian Tambahan')
                            ->schema([
                                TextInput::make('field_name')
                                    ->label('Kunci JSON')
                                    ->placeholder('contoh: nik')
                                    ->required(),
                                
                                TextInput::make('label')
                                    ->label('Label Tampilan')
                                    ->placeholder('contoh: Nomor Induk Kependudukan')
                                    ->required(),
                                
                                Select::make('type')
                                    ->label('Tipe Input')
                                    ->options([
                                        'text' => 'Teks Singkat',
                                        'number' => 'Angka',
                                        'textarea' => 'Teks Panjang',
                                        'date' => 'Tanggal',
                                    ])
                                    ->required(),
                                
                                Toggle::make('is_required')
                                    ->label('Wajib Diisi'),
                            ])
                            ->columns(4)
                            ->reorderable()
                            ->itemLabel(fn (array $state): ?string => $state['label'] ?? null),
                    ])->collapsible(),

                Section::make('Konfigurasi Berkas')
                    ->description('Atur persyaratan dokumen yang wajib diunggah.')
                    ->icon('heroicon-m-document-arrow-up')
                    ->schema([
                        Repeater::make('document_schema')
                            ->label('Daftar Berkas')
                            ->schema([
                                TextInput::make('document_key')
                                    ->label('Kunci Berkas')
                                    ->placeholder('contoh: kartu_keluarga')
                                    ->required(),
                                
                                TextInput::make('label')
                                    ->label('Nama Berkas')
                                    ->placeholder('contoh: Scan Kartu Keluarga')
                                    ->required(),
                                
                                Toggle::make('is_required')
                                    ->label('Wajib Unggah'),
                            ])
                            ->columns(3)
                            ->reorderable()
                            ->itemLabel(fn (array $state): ?string => $state['label'] ?? null),
                    ])->collapsible(),
            ]);
    }
}