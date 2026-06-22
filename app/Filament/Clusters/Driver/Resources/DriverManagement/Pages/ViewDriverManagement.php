<?php

namespace App\Filament\Clusters\Driver\Resources\DriverManagement\Pages;

use App\Filament\Clusters\Driver\Resources\DriverManagement\Actions\DriverManagementActions;
use App\Filament\Clusters\Driver\Resources\DriverManagement\DriverManagementResource;
use Filament\Actions\Action;
use Filament\Resources\Pages\ViewRecord;
use Filament\Support\Icons\Heroicon;

class ViewDriverManagement extends ViewRecord
{
    protected static string $resource = DriverManagementResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('back_to_drivers')
                ->label('Quay lại danh sách')
                ->icon(Heroicon::OutlinedArrowLeft)
                ->color('gray')
                ->url(DriverManagementResource::getUrl('index')),
            DriverManagementActions::approve(),
            DriverManagementActions::reject(),
            DriverManagementActions::lock(),
            DriverManagementActions::unlock(),
            DriverManagementActions::assignGroup(),
        ];
    }
}
