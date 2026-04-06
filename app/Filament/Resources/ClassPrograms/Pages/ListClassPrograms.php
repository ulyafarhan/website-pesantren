<?php

namespace App\Filament\Resources\ClassPrograms\Pages;

use App\Filament\Resources\ClassPrograms\ClassProgramResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListClassPrograms extends ListRecords
{
    protected static string $resource = ClassProgramResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
