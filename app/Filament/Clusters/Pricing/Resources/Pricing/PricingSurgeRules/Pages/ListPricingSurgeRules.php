<?php

namespace App\Filament\Clusters\Pricing\Resources\Pricing\PricingSurgeRules\Pages;

use App\Filament\Clusters\Pricing\Resources\Pricing\PricingSurgeRules\PricingSurgeRuleResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListPricingSurgeRules extends ListRecords
{
    protected static string $resource = PricingSurgeRuleResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
