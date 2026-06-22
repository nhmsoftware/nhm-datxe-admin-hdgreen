<?php

namespace App\Filament\Clusters\Pricing\Resources\Finance\CommissionRules\Pages;

use App\Filament\Clusters\Pricing\Resources\Finance\CommissionRules\CommissionRuleResource;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Validation\ValidationException;

class CreateCommissionRule extends CreateRecord
{
    protected static string $resource = CommissionRuleResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        if (CommissionRuleResource::hasDuplicateActiveRule($data)) {
            Notification::make()
                ->danger()
                ->title('Đã tồn tại cấu hình hoa hồng đang hoạt động.')
                ->send();

            throw ValidationException::withMessages([
                'data.service_type' => 'Đã tồn tại cấu hình hoa hồng đang hoạt động.',
            ]);
        }

        return $data;
    }

    protected function getCreatedNotificationTitle(): ?string
    {
        return 'Cập nhật cấu hình hoa hồng thành công.';
    }
}
