<?php

namespace App\Filament\Clusters\Driver\Resources\DriverManagement\Pages;

use App\Filament\Clusters\Driver\Resources\DriverManagement\DriverManagementResource;
use Filament\Resources\Pages\ListRecords;

class ListDriverManagement extends ListRecords
{
    protected static string $resource = DriverManagementResource::class;

    protected function getHeaderActions(): array
    {
        return [];
    }
}
