<?php

namespace App\Filament\Clusters\Marketing\Resources\Marketing\News\Pages;

use App\Filament\Clusters\Marketing\Resources\Marketing\News\NewsResource;
use Filament\Resources\Pages\CreateRecord;

class CreateNews extends CreateRecord
{
    protected static string $resource = NewsResource::class;

    protected function getCreatedNotificationTitle(): ?string
    {
        return 'Lưu tin tức thành công.';
    }
}
