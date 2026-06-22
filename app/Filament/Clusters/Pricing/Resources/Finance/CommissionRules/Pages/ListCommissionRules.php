<?php

namespace App\Filament\Clusters\Pricing\Resources\Finance\CommissionRules\Pages;

use App\Filament\Clusters\Pricing\Resources\Finance\CommissionRules\CommissionRuleResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListCommissionRules extends ListRecords
{
    protected static string $resource = CommissionRuleResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
