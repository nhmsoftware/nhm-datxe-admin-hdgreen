<?php

namespace App\Filament\Clusters\DriverFinance\Resources\Finance\DriverCommissionRules\Pages;

use App\Filament\Clusters\DriverFinance\Resources\Finance\DriverCommissionRules\DriverCommissionRuleResource;
use App\Models\Finance\Enums\CommissionTargetType;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Validation\ValidationException;

class CreateDriverCommissionRule extends CreateRecord
{
    protected static string $resource = DriverCommissionRuleResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['target_type'] = CommissionTargetType::DRIVER->value;

        if (DriverCommissionRuleResource::hasOverlappingActiveRule($data)) {
            Notification::make()
                ->danger()
                ->title('Đã tồn tại cấu hình hoa hồng đang hoạt động trong khoảng thời gian này.')
                ->send();

            throw ValidationException::withMessages([
                'data.service_type' => 'Đã tồn tại cấu hình hoa hồng đang hoạt động trong khoảng thời gian này.',
            ]);
        }

        return $data;
    }

    protected function getCreatedNotificationTitle(): ?string
    {
        return 'Commission Model Updated Successfully.';
    }
}
