<?php

namespace App\Filament\Clusters\DriverFinance\Resources\Finance\SubscriptionPackages\RelationManagers;

use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class DriverSubscriptionsRelationManager extends RelationManager
{
    protected static string $relationship = 'driverSubscriptions';

    protected static ?string $title = 'Tài xế đang sử dụng';

    public function isReadOnly(): bool
    {
        return true;
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('driver.full_name')
                    ->label('Tài xế')
                    ->placeholder('Chưa có dữ liệu')
                    ->searchable(),
                TextColumn::make('status')
                    ->label('Trạng thái')
                    ->badge(),
                TextColumn::make('price_paid')
                    ->label('Đã thanh toán')
                    ->money('VND'),
                TextColumn::make('started_at')
                    ->label('Bắt đầu')
                    ->dateTime('d/m/Y H:i'),
                TextColumn::make('expires_at')
                    ->label('Hết hạn')
                    ->dateTime('d/m/Y H:i'),
            ])
            ->headerActions([])
            ->recordActions([])
            ->toolbarActions([]);
    }
}
