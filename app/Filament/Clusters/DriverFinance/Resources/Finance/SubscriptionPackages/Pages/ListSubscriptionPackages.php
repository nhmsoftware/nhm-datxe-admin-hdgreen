<?php

namespace App\Filament\Clusters\DriverFinance\Resources\Finance\SubscriptionPackages\Pages;

use App\Filament\Clusters\DriverFinance\Resources\Finance\SubscriptionPackages\SubscriptionPackageResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListSubscriptionPackages extends ListRecords
{
    protected static string $resource = SubscriptionPackageResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }

    public function getTitle(): string
    {
        return 'Gói thuê bao';
    }
}
