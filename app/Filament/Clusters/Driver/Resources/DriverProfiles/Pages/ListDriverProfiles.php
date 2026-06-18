<?php

namespace App\Filament\Clusters\Driver\Resources\DriverProfiles\Pages;

use App\Filament\Clusters\Driver\Resources\DriverProfiles\DriverProfileResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListDriverProfiles extends ListRecords
{
    protected static string $resource = DriverProfileResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
