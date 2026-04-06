<?php

namespace App\Filament\Resources\ClassPrograms;

use App\Filament\Resources\ClassPrograms\Pages\CreateClassProgram;
use App\Filament\Resources\ClassPrograms\Pages\EditClassProgram;
use App\Filament\Resources\ClassPrograms\Pages\ListClassPrograms;
use App\Filament\Resources\ClassPrograms\Schemas\ClassProgramForm;
use App\Filament\Resources\ClassPrograms\Tables\ClassProgramsTable;
use App\Models\ClassProgram;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class ClassProgramResource extends Resource
{
    protected static ?string $model = ClassProgram::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::BuildingLibrary;

    public static function getPluralModelLabel(): string
    {
        return 'Program Kelas';
    }

    public static function getModelLabel(): string
    {
        return 'Program Kelas';
    }

    public static function form(Schema $schema): Schema
    {
        return ClassProgramForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ClassProgramsTable::configure($table);
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
            'index' => ListClassPrograms::route('/'),
            'create' => CreateClassProgram::route('/create'),
            'edit' => EditClassProgram::route('/{record}/edit'),
        ];
    }
}
