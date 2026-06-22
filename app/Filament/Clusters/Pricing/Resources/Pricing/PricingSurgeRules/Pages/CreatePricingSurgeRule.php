<?php

namespace App\Filament\Clusters\Pricing\Resources\Pricing\PricingSurgeRules\Pages;

use App\Filament\Clusters\Pricing\Resources\Pricing\PricingSurgeRules\PricingSurgeRuleResource;
use Filament\Resources\Pages\CreateRecord;

class CreatePricingSurgeRule extends CreateRecord
{
    protected static string $resource = PricingSurgeRuleResource::class;

    protected function getCreatedNotificationTitle(): ?string
    {
        return 'Cập nhật cấu hình giá giờ cao điểm thành công.';
    }
}
