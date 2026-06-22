<?php

namespace App\Filament\Clusters\User\Resources\Customers\Pages;

use App\Filament\Clusters\User\Resources\Customers\Actions\CustomerAccountActions;
use App\Filament\Clusters\User\Resources\Customers\CustomerResource;
use Filament\Actions\Action;
use Filament\Resources\Pages\ViewRecord;
use Filament\Support\Icons\Heroicon;

class ViewCustomer extends ViewRecord
{
    protected static string $resource = CustomerResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('back_to_customers')
                ->label('Quay lại danh sách')
                ->icon(Heroicon::OutlinedArrowLeft)
                ->color('gray')
                ->url(CustomerResource::getUrl('index')),
            CustomerAccountActions::lock(),
            CustomerAccountActions::unlock(),
        ];
    }
}
