<?php

namespace App\Filament\Clusters\Driver\Resources\DriverProfiles\Tables;

use App\Models\User\Enums\DriverStatus;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ForceDeleteBulkAction;
use Filament\Actions\RestoreBulkAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;

class DriverProfilesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('full_name')
                    ->label('Tài xế')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('user.phone')
                    ->label('Số điện thoại')
                    ->searchable()
                    ->toggleable(),
                TextColumn::make('user.email')
                    ->label('Email')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('vehicleTypeRef.name_vi')
                    ->label('Loại xe')
                    ->sortable()
                    ->toggleable(),
                TextColumn::make('vehicle_name')
                    ->label('Tên xe')
                    ->searchable()
                    ->toggleable(),
                TextColumn::make('vehicle_number')
                    ->label('Biển số')
                    ->searchable(),
                TextColumn::make('status')
                    ->label('Trạng thái')
                    ->badge()
                    ->formatStateUsing(fn (?DriverStatus $state): string => $state?->getLabel() ?? 'Chưa xác định')
                    ->color(fn (?DriverStatus $state): string => match ($state) {
                        DriverStatus::ACTIVE => 'success',
                        DriverStatus::BUSY => 'warning',
                        DriverStatus::COOLDOWN, DriverStatus::DISPATCH_LOCKED => 'gray',
                        DriverStatus::BANNED => 'danger',
                        default => 'gray',
                    })
                    ->sortable(),
                IconColumn::make('is_online')
                    ->label('Online')
                    ->boolean()
                    ->sortable(),
                TextColumn::make('average_rating')
                    ->label('Đánh giá')
                    ->numeric(decimalPlaces: 2)
                    ->sortable(),
                TextColumn::make('total_trips')
                    ->label('Tổng chuyến')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('updated_at')
                    ->label('Cập nhật')
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->label('Trạng thái')
                    ->options(self::driverStatusOptions()),
                TernaryFilter::make('is_online')
                    ->label('Online'),
                TrashedFilter::make(),
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                    RestoreBulkAction::make(),
                    ForceDeleteBulkAction::make(),
                ]),
            ]);
    }

    private static function driverStatusOptions(): array
    {
        $options = [];

        foreach (DriverStatus::cases() as $status) {
            $options[$status->value] = $status->getLabel();
        }

        return $options;
    }
}
