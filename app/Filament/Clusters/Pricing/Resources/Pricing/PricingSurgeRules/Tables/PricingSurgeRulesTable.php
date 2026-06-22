<?php

namespace App\Filament\Clusters\Pricing\Resources\Pricing\PricingSurgeRules\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class PricingSurgeRulesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('vehicleTypeRef.name_vi')
                    ->label('Loại xe')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('conditions')
                    ->label('Điều kiện')
                    ->badge()
                    ->formatStateUsing(fn (array|string|null $state): string => collect((array) $state)
                        ->map(fn (string $condition): string => match ($condition) {
                            'rush_hour' => 'Giờ cao điểm',
                            'bad_weather' => 'Thời tiết xấu',
                            default => $condition,
                        })
                        ->join(', ')),
                TextColumn::make('multiplier')
                    ->label('Hệ số')
                    ->numeric(decimalPlaces: 2)
                    ->sortable(),
                TextColumn::make('start_time')
                    ->label('Bắt đầu'),
                TextColumn::make('end_time')
                    ->label('Kết thúc'),
                TextColumn::make('area_id')
                    ->label('Khu vực')
                    ->placeholder('Toàn hệ thống')
                    ->toggleable(),
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
