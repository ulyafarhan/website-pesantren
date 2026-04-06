<?php

namespace App\Filament\Resources\ClassPrograms\Pages;

use App\Filament\Resources\ClassPrograms\ClassProgramResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditClassProgram extends EditRecord
{
    protected static string $resource = ClassProgramResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
