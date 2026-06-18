<?php

namespace App\Filament\Clusters\Driver\Resources\DriverReviewApplications\Tables;

use App\Models\Driver\Enums\KycStatus;
use App\Models\Driver\Enums\KycType;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class DriverReviewApplicationsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('user.phone')
                    ->label('Số điện thoại')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('user.full_name')
                    ->label('Tên người dùng')
                    ->searchable()
                    ->toggleable(),
                TextColumn::make('kyc_type')
                    ->label('Loại hồ sơ')
                    ->badge()
                    ->formatStateUsing(fn (?KycType $state): string => $state?->getLabel() ?? 'Không xác định')
                    ->sortable(),
                TextColumn::make('kyc_status')
                    ->label('Trạng thái')
                    ->badge()
                    ->formatStateUsing(fn (?KycStatus $state): string => $state?->getLabel() ?? 'Không xác định')
                    ->color(fn (?KycStatus $state): string => match ($state) {
                        KycStatus::PENDING => 'warning',
                        KycStatus::APPROVED => 'success',
                        KycStatus::REJECTED => 'danger',
                        default => 'gray',
                    })
                    ->sortable(),
                TextColumn::make('files_count')
                    ->label('Tài liệu')
                    ->counts('files')
                    ->sortable(),
                TextColumn::make('cancel_reason')
                    ->label('Lý do')
                    ->limit(40)
                    ->toggleable(),
                TextColumn::make('created_at')
                    ->label('Ngày nộp')
                    ->dateTime('d/m/Y H:i')
                    ->sortable(),
                TextColumn::make('updated_at')
                    ->label('Cập nhật')
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('kyc_type')
                    ->label('Loại hồ sơ')
                    ->options(self::kycTypeOptions()),
                SelectFilter::make('kyc_status')
                    ->label('Trạng thái')
                    ->options(self::kycStatusOptions()),
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

    private static function kycTypeOptions(): array
    {
        $options = [];

        foreach (KycType::cases() as $type) {
            $options[$type->value] = $type->getLabel();
        }

        return $options;
    }

    private static function kycStatusOptions(): array
    {
        $options = [];

        foreach (KycStatus::cases() as $status) {
            $options[$status->value] = $status->getLabel();
        }

        return $options;
    }
}
