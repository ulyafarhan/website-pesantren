<?php

namespace App\Filament\Resources\RegistrationPeriods\Pages;

use App\Filament\Resources\RegistrationPeriods\RegistrationPeriodResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListRegistrationPeriods extends ListRecords
{
    protected static string $resource = RegistrationPeriodResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
