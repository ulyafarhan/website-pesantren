<?php

namespace App\Filament\Resources\Registrations\Tables;

use App\Filament\Exports\RegistrationExporter;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Actions\EditAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\ExportAction;
use Filament\Tables\Filters\SelectFilter;

class RegistrationsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('registration_number')
                    ->label('No. Daftar')
                    ->searchable()
                    ->sortable()
                    ->copyable()
                    ->fontFamily('mono'),

                TextColumn::make('full_name')
                    ->label('Nama Lengkap')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('gender')
                    ->label('L/P')
                    ->formatStateUsing(fn (string $state): string => $state === 'L' ? 'L' : 'P')
                    ->tooltip(fn (string $state): string => $state === 'L' ? 'Laki-laki' : 'Perempuan')
                    ->alignCenter(),

                TextColumn::make('period.name')
                    ->label('Gelombang')
                    ->sortable()
                    ->toggleable(),

                TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'PENDING' => 'gray',
                        'VERIFIED' => 'info',
                        'TESTING' => 'warning',
                        'ACCEPTED' => 'success',
                        'REGISTERED' => 'primary',
                        'REJECTED' => 'danger',
                        default => 'gray',
                    })
                    ->sortable(),

                TextColumn::make('test_score')
                    ->label('Skor')
                    ->numeric(decimalPlaces: 1)
                    ->sortable()
                    ->alignCenter()
                    ->toggleable(),

                TextColumn::make('created_at')
                    ->label('Tgl Daftar')
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                // Filter berdasarkan Gelombang Pendaftaran
                SelectFilter::make('registration_period_id')
                    ->label('Gelombang')
                    ->relationship('period', 'name'),
                
                // Filter berdasarkan Tahapan Seleksi
                SelectFilter::make('status')
                    ->options([
                        'PENDING' => 'Menunggu Verifikasi',
                        'VERIFIED' => 'Terverifikasi',
                        'TESTING' => 'Tahap Seleksi',
                        'ACCEPTED' => 'Diterima',
                        'REJECTED' => 'Ditolak',
                    ]),
            ])
            ->headerActions([
                ExportAction::make()
                    ->exporter(RegistrationExporter::class)
                    ->columnMapping(true),
            ])
            ->actions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('created_at', 'desc');
    }
}