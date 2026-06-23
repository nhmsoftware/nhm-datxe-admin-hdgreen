<?php

namespace App\Filament\Clusters\DriverFinance\Resources\Finance\DriverCommissionRules\Pages;

use App\Filament\Clusters\DriverFinance\Resources\Finance\DriverCommissionRules\DriverCommissionRuleResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListDriverCommissionRules extends ListRecords
{
    protected static string $resource = DriverCommissionRuleResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }

    public function getTitle(): string
    {
        return 'Mô hình hoa hồng tài xế';
    }
}
