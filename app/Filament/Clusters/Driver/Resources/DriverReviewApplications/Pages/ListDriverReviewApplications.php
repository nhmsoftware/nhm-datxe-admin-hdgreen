<?php

namespace App\Filament\Clusters\Driver\Resources\DriverReviewApplications\Pages;

use App\Filament\Clusters\Driver\Resources\DriverReviewApplications\DriverReviewApplicationResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListDriverReviewApplications extends ListRecords
{
    protected static string $resource = DriverReviewApplicationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
