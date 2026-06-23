<?php

namespace App\Filament\Clusters\Pricing\Resources\Pricing\PricingConfigs\Pages;

use App\Filament\Clusters\Pricing\Resources\Pricing\PricingConfigs\PricingConfigResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditPricingConfig extends EditRecord
{
    protected static string $resource = PricingConfigResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }

    protected function getSavedNotificationTitle(): ?string
    {
        return 'Cập nhật cấu hình giá thành công.';
    }
}
