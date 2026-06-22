<?php

namespace App\Filament\Clusters\Pricing\Resources\Finance\CommissionRules\Pages;

use App\Filament\Clusters\Pricing\Resources\Finance\CommissionRules\CommissionRuleResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Actions\RestoreAction;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Validation\ValidationException;

class EditCommissionRule extends EditRecord
{
    protected static string $resource = CommissionRuleResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
            ForceDeleteAction::make(),
            RestoreAction::make(),
        ];
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        if (CommissionRuleResource::hasDuplicateActiveRule($data, (string) $this->getRecord()->getKey())) {
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

    protected function getSavedNotificationTitle(): ?string
    {
        return 'Cập nhật cấu hình hoa hồng thành công.';
    }
}
