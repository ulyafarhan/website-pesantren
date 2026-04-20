<?php

namespace App\Filament\Exports;

use App\Models\Registration;
use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Exporter;
use Filament\Actions\Exports\Models\Export;

class RegistrationExporter extends Exporter
{
    protected static ?string $model = Registration::class;

    public static function getColumns(): array
    {
        return [
            ExportColumn::make('registration_number')->label('No. Pendaftaran'),
            ExportColumn::make('full_name')->label('Nama Lengkap'),
            ExportColumn::make('period.name')->label('Gelombang/Periode'),
            ExportColumn::make('status')->label('Status'),
            
            // PENTING: Mengekstrak data JSON dinamis ke dalam kolom Excel tersendiri
            ExportColumn::make('data.nik')->label('NIK'),
            ExportColumn::make('data.asal_sekolah')->label('Asal Sekolah'),
            ExportColumn::make('data.nama_ayah')->label('Nama Ayah'),
            ExportColumn::make('data.no_hp')->label('No WhatsApp'),
            
            ExportColumn::make('created_at')->label('Tanggal Daftar'),
        ];
    }

    public static function getCompletedNotificationBody(Export $export): string
    {
        $body = 'Ekspor data pendaftar telah selesai dan siap diunduh.';

        if ($failedRowsCount = $export->getFailedRowsCount()) {
            $body .= ' ' . number_format($failedRowsCount) . ' baris gagal diekspor.';
        }

        return $body;
    }
}