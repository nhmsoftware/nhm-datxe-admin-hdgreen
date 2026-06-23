<?php

namespace App\Filament\Clusters\DriverFinance\Resources\Finance\SubscriptionPackages\Tables;

use App\Models\Finance\DriverSubscription;
use App\Models\Finance\SubscriptionPackage;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ForceDeleteBulkAction;
use Filament\Actions\RestoreBulkAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;

class SubscriptionPackagesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label('Tên gói')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('package_type')
                    ->label('Loại gói')
                    ->badge()
                    ->formatStateUsing(fn (?string $state): string => match ($state) {
                        'daily' => 'Hàng ngày',
                        'weekly' => 'Hàng tuần',
                        'monthly' => 'Hàng tháng',
                        default => $state ?? 'Không xác định',
                    }),
                TextColumn::make('price')
                    ->label('Giá')
                    ->money('VND')
                    ->sortable(),
                TextColumn::make('duration_days')
                    ->label('Thời hạn')
                    ->suffix(' ngày')
                    ->sortable(),
                TextColumn::make('service_fee_reduction_percent')
                    ->label('Giảm phí dịch vụ')
                    ->suffix('%')
                    ->sortable(),
                TextColumn::make('driver_subscriptions_count')
                    ->label('Subscriber active')
                    ->counts([
                        'driverSubscriptions' => fn ($query) => $query
                            ->where('status', 'active')
                            ->where('expires_at', '>', now()),
                    ]),
                IconColumn::make('is_active')
                    ->label('Mở bán')
                    ->boolean()
                    ->sortable(),
            ])
            ->filters([
                TrashedFilter::make(),
            ])
            ->recordActions([
                EditAction::make(),
                Action::make('disable_package')
                    ->label('Vô hiệu hóa')
                    ->color('warning')
                    ->icon('heroicon-o-pause-circle')
                    ->visible(fn (SubscriptionPackage $record): bool => (bool) $record->is_active)
                    ->requiresConfirmation()
                    ->modalHeading('Vô hiệu hóa gói thuê bao')
                    ->modalDescription('Gói sẽ ngừng mở bán cho tài xế mới. Tài xế đang dùng vẫn tiếp tục hiệu lực đến hết hạn.')
                    ->action(function (SubscriptionPackage $record): void {
                        $record->update(['is_active' => false]);
                    }),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                    ForceDeleteBulkAction::make(),
                    RestoreBulkAction::make(),
                ]),
            ]);
    }
}
