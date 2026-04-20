<?php

namespace App\Filament\Resources\Brochures\Pages;

use App\Filament\Resources\Brochures\BrochureResource;
use Filament\Resources\Pages\CreateRecord;

class CreateBrochure extends CreateRecord
{
    protected static string $resource = BrochureResource::class;
}
