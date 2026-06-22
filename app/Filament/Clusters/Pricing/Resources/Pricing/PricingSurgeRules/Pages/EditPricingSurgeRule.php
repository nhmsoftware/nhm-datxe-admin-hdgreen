<?php

namespace App\Filament\Clusters\Pricing\Resources\Pricing\PricingSurgeRules\Pages;

use App\Filament\Clusters\Pricing\Resources\Pricing\PricingSurgeRules\PricingSurgeRuleResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditPricingSurgeRule extends EditRecord
{
    protected static string $resource = PricingSurgeRuleResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }

    protected function getSavedNotificationTitle(): ?string
    {
        return 'Cập nhật cấu hình giá giờ cao điểm thành công.';
    }
}
