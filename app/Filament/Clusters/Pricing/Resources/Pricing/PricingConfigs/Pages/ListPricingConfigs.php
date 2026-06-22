<?php

namespace App\Filament\Clusters\Pricing\Resources\Pricing\PricingConfigs\Pages;

use App\Filament\Clusters\Pricing\Resources\Pricing\PricingConfigs\PricingConfigResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListPricingConfigs extends ListRecords
{
    protected static string $resource = PricingConfigResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
