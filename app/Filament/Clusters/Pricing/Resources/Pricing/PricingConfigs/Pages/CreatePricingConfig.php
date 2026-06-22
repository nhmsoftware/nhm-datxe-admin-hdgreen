<?php

namespace App\Filament\Clusters\Pricing\Resources\Pricing\PricingConfigs\Pages;

use App\Filament\Clusters\Pricing\Resources\Pricing\PricingConfigs\PricingConfigResource;
use Filament\Resources\Pages\CreateRecord;

class CreatePricingConfig extends CreateRecord
{
    protected static string $resource = PricingConfigResource::class;

    protected function getCreatedNotificationTitle(): ?string
    {
        return 'Cập nhật cấu hình giá thành công.';
    }
}
