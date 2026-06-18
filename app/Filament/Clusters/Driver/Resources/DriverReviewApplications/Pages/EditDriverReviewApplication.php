<?php

namespace App\Filament\Clusters\Driver\Resources\DriverReviewApplications\Pages;

use App\Filament\Clusters\Driver\Resources\DriverReviewApplications\DriverReviewApplicationResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditDriverReviewApplication extends EditRecord
{
    protected static string $resource = DriverReviewApplicationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
