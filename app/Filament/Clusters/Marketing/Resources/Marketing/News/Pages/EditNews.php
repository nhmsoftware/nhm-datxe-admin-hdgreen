<?php

namespace App\Filament\Clusters\Marketing\Resources\Marketing\News\Pages;

use App\Filament\Clusters\Marketing\Resources\Marketing\News\NewsResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Actions\RestoreAction;
use Filament\Resources\Pages\EditRecord;

class EditNews extends EditRecord
{
    protected static string $resource = NewsResource::class;

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
        $data['image_url'] = $this->getRecord()->raw_image_path;

        return $data;
    }

    protected function getSavedNotificationTitle(): ?string
    {
        return 'Lưu tin tức thành công.';
    }
}
