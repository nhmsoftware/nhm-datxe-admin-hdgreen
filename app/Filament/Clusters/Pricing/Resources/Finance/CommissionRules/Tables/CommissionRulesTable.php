<?php

namespace App\Filament\Clusters\Pricing\Resources\Finance\CommissionRules\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ForceDeleteBulkAction;
use Filament\Actions\RestoreBulkAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;

class CommissionRulesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label('Tên cấu hình')
                    ->searchable()
                    ->placeholder('Chưa đặt tên'),
                TextColumn::make('target_type')
                    ->label('Đối tượng')
                    ->badge()
                    ->formatStateUsing(fn ($state): string => $state?->label() ?? 'Không xác định'),
                TextColumn::make('service_type')
                    ->label('Loại dịch vụ')
                    ->badge()
                    ->formatStateUsing(fn ($state): string => $state?->getLabel() ?? 'Không xác định'),
                TextColumn::make('scope')
                    ->label('Phạm vi')
                    ->formatStateUsing(fn ($state): string => $state?->getLabel() ?? 'Không xác định'),
                TextColumn::make('commission_rate')
                    ->label('Tỷ lệ')
                    ->suffix('%')
                    ->sortable(),
                IconColumn::make('is_active')
                    ->label('Hoạt động')
                    ->boolean()
                    ->sortable(),
            ])
            ->filters([
                TrashedFilter::make(),
            ])
            ->recordActions([
                EditAction::make(),
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
