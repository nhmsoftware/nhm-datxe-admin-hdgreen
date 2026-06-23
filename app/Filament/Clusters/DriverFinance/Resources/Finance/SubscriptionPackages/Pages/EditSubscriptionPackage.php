<?php

namespace App\Filament\Clusters\DriverFinance\Resources\Finance\SubscriptionPackages\Pages;

use App\Filament\Clusters\DriverFinance\Resources\Finance\SubscriptionPackages\SubscriptionPackageResource;
use App\Models\Finance\SubscriptionPackage;
use Filament\Actions\DeleteAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Actions\RestoreAction;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Validation\ValidationException;

class EditSubscriptionPackage extends EditRecord
{
    protected static string $resource = SubscriptionPackageResource::class;

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
        $exists = SubscriptionPackage::query()
            ->where('name', $data['name'] ?? null)
            ->whereKeyNot($this->getRecord()->getKey())
            ->exists();

        if ($exists) {
            Notification::make()
                ->danger()
                ->title('Gói thuê bao này đã tồn tại.')
                ->send();

            throw ValidationException::withMessages([
                'data.name' => 'Gói thuê bao này đã tồn tại.',
            ]);
        }

        return $data;
    }

    protected function getSavedNotificationTitle(): ?string
    {
        return 'Cấu hình gói thuê bao thành công.';
    }
}
