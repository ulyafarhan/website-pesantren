<?php

namespace App\Filament\Resources\SiteSettings;

use App\Filament\Resources\SiteSettings\Pages;
use App\Models\SiteSetting;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Tables\Table;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;


class SiteSettingResource extends Resource
{
    protected static ?string $model = SiteSetting::class;
    protected static ?string $navigationLabel = 'Pengaturan Website';
    protected static ?string $pluralModelLabel = 'Pengaturan Website';
    protected static string|BackedEnum|null $navigationIcon = Heroicon::Cog8Tooth;
    protected static ?int $navigationSort = 9999;

    public static function canCreate(): bool
    {
        return SiteSetting::count() === 0;
    }

    public static function form(Schema $schema): Schema
    {
        return Schemas\SiteSettingForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return Tables\SiteSettingsTable::configure($table);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSiteSettings::route('/'),
            'create' => Pages\CreateSiteSetting::route('/create'),
            'edit' => Pages\EditSiteSetting::route('/{record}/edit'),
        ];
    }
}