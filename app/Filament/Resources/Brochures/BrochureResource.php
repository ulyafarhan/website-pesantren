<?php

namespace App\Filament\Resources\Brochures;

use App\Filament\Resources\Brochures\Pages\CreateBrochure;
use App\Filament\Resources\Brochures\Pages\EditBrochure;
use App\Filament\Resources\Brochures\Pages\ListBrochures;
use App\Filament\Resources\Brochures\Schemas\BrochureForm;
use App\Filament\Resources\Brochures\Tables\BrochuresTable;
use App\Models\Brochure;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class BrochureResource extends Resource
{
    protected static ?string $model = Brochure::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::PaperClip;

    public static function getPluralModelLabel(): string
    {
        return 'Brosur';
    }

    public static function getModelLabel(): string
    {
        return 'Brosur';
    }


    public static function form(Schema $schema): Schema
    {
        return BrochureForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return BrochuresTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListBrochures::route('/'),
            'create' => CreateBrochure::route('/create'),
            'edit' => EditBrochure::route('/{record}/edit'),
        ];
    }
}
