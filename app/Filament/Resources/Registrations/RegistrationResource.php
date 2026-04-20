<?php

namespace App\Filament\Resources\Registrations;

use App\Filament\Resources\Registrations\Pages;
use App\Models\Registration;
use Filament\Resources\Resource;
use Filament\Tables\Table;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use BackedEnum;
use App\Filament\Resources\Registrations\Schemas\RegistrationForm;

class RegistrationResource extends Resource
{
    protected static ?string $model = Registration::class;

    protected static ?string $navigationLabel = 'Data Pendaftar';

    protected static ?string $pluralModelLabel = 'Data Pendaftar';

    protected static ?string $navigationGroupLabel = 'PPDB';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::AcademicCap;

    /**
     * Memanggil konfigurasi form dari class RegistrationForm
     */
    public static function form(Schema $schema): Schema
    {
        return RegistrationForm::configure($schema);
    }

    /**
     * Memanggil konfigurasi table dari class RegistrationsTable
     */
    public static function table(Table $table): Table
    {
        return \App\Filament\Resources\Registrations\Tables\RegistrationsTable::configure($table);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListRegistrations::route('/'),
            'create' => Pages\CreateRegistration::route('/create'),
            'edit' => Pages\EditRegistration::route('/{record}/edit'),
        ];
    }
}