<?php

namespace App\Filament\Clusters\DriverFinance\Resources\Finance\DriverCommissionRules\Pages;

use App\Filament\Clusters\DriverFinance\Resources\Finance\DriverCommissionRules\DriverCommissionRuleResource;
use App\Models\Finance\Enums\CommissionTargetType;
use Filament\Actions\DeleteAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Actions\RestoreAction;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Validation\ValidationException;

class EditDriverCommissionRule extends EditRecord
{
    protected static string $resource = DriverCommissionRuleResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
            ForceDeleteAction::make(),
            RestoreAction::make(),
        ];
    }

    protected function mutateFormDataBeforeFill(array $data): array
    {
        unset($data['target_type']);

        return $data;
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        $data['target_type'] = CommissionTargetType::DRIVER->value;

        if (DriverCommissionRuleResource::hasOverlappingActiveRule($data, (string) $this->getRecord()->getKey())) {
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

    protected function getSavedNotificationTitle(): ?string
    {
        return 'Commission Model Updated Successfully.';
    }
}
