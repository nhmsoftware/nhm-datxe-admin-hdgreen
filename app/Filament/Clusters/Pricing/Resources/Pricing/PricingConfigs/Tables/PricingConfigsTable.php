<?php

namespace App\Filament\Clusters\Pricing\Resources\Pricing\PricingConfigs\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class PricingConfigsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('vehicleTypeRef.name_vi')
                    ->label('Loại xe')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('base_price')
                    ->label('Giá mở cửa')
                    ->money('VND')
                    ->sortable(),
                TextColumn::make('min_fare')
                    ->label('Giá tối thiểu')
                    ->money('VND')
                    ->sortable(),
                TextColumn::make('distance_rate')
                    ->label('Giá/km')
                    ->money('VND')
                    ->sortable(),
                TextColumn::make('time_rate')
                    ->label('Giá/phút')
                    ->money('VND')
                    ->sortable(),
                TextColumn::make('commission_rate')
                    ->label('Hoa hồng')
                    ->suffix('%')
                    ->sortable(),
                IconColumn::make('is_active')
                    ->label('Hoạt động')
                    ->boolean()
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
