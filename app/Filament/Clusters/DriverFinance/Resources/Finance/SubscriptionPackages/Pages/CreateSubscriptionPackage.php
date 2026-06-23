<?php

namespace App\Filament\Clusters\DriverFinance\Resources\Finance\SubscriptionPackages\Pages;

use App\Filament\Clusters\DriverFinance\Resources\Finance\SubscriptionPackages\SubscriptionPackageResource;
use App\Models\Finance\SubscriptionPackage;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Validation\ValidationException;

class CreateSubscriptionPackage extends CreateRecord
{
    protected static string $resource = SubscriptionPackageResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $exists = SubscriptionPackage::query()
            ->where('name', $data['name'] ?? null)
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

    protected function getCreatedNotificationTitle(): ?string
    {
        return 'Cấu hình gói thuê bao thành công.';
    }
}
