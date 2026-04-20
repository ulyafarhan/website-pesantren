<?php

namespace App\Filament\Resources\RegistrationPeriods;

use App\Filament\Resources\RegistrationPeriods\Pages;
use App\Filament\Resources\RegistrationPeriods\Schemas\RegistrationPeriodForm;
use App\Filament\Resources\RegistrationPeriods\Tables\RegistrationPeriodsTable;
use App\Models\RegistrationPeriod;
use Filament\Resources\Resource;
use Filament\Tables\Table;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use BackedEnum;

class RegistrationPeriodResource extends Resource
{
    protected static ?string $model = RegistrationPeriod::class;

    protected static ?string $navigationLabel = 'Gelombang Pendaftaran';

    protected static ?string $pluralModelLabel = 'Gelombang Pendaftaran';

    protected static ?string $navigationGroupLabel = 'PPDB';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::CalendarDays;

    /**
     * Memanggil konfigurasi form dari class RegistrationPeriodForm
     */
    public static function form(Schema $schema): Schema
    {
        return RegistrationPeriodForm::configure($schema);
    }

    /**
     * Memanggil konfigurasi table dari class RegistrationPeriodsTable
     */
    public static function table(Table $table): Table
    {
        return RegistrationPeriodsTable::configure($table);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListRegistrationPeriods::route('/'),
            'create' => Pages\CreateRegistrationPeriod::route('/create'),
            'edit' => Pages\EditRegistrationPeriod::route('/{record}/edit'),
        ];
    }
}