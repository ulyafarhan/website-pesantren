<?php

namespace App\Filament\Resources\RegistrationPeriods\Pages;

use App\Filament\Resources\RegistrationPeriods\RegistrationPeriodResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditRegistrationPeriod extends EditRecord
{
    protected static string $resource = RegistrationPeriodResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
