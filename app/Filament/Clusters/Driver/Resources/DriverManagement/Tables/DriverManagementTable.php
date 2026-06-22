<?php

namespace App\Filament\Clusters\Driver\Resources\DriverManagement\Tables;

use App\Filament\Clusters\Driver\Resources\DriverManagement\Actions\DriverManagementActions;
use App\Filament\Clusters\Driver\Resources\DriverManagement\DriverManagementResource;
use App\Models\User;
use App\Models\User\Enums\KycStatus;
use App\Models\User\Enums\KycType;
use Filament\Actions\ViewAction;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class DriverManagementTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->poll('10s')
            ->columns([
                TextColumn::make('full_name')
                    ->label('Họ và tên')
                    ->searchable(query: function (Builder $query, string $search): Builder {
                        return $query->where(function (Builder $query) use ($search): void {
                            $query->where('name', 'like', "%{$search}%")
                                ->orWhereHas('driverProfile', fn (Builder $query) => $query->where('full_name', 'like', "%{$search}%"));
                        });
                    })
                    ->sortable(query: fn (Builder $query, string $direction) => $query->orderBy('name', $direction))
                    ->placeholder('Chưa cập nhật'),
                TextColumn::make('phone')
                    ->label('Số điện thoại')
                    ->searchable()
                    ->copyable()
                    ->placeholder('Chưa cập nhật'),
                TextColumn::make('email')
                    ->label('Email')
                    ->searchable()
                    ->copyable()
                    ->placeholder('Chưa cập nhật'),
                TextColumn::make('is_active')
                    ->label('Trạng thái tài khoản')
                    ->badge()
                    ->formatStateUsing(fn (bool $state): string => $state ? 'Active' : 'Locked')
                    ->color(fn (bool $state): string => $state ? 'success' : 'danger')
                    ->sortable(),
                TextColumn::make('latestDriverApplication.kyc_status')
                    ->label('Trạng thái duyệt')
                    ->badge()
                    ->formatStateUsing(fn (?KycStatus $state): string => $state?->label() ?? KycStatus::NotSubmitted->label())
                    ->color(fn (?KycStatus $state): string => match ($state) {
                        KycStatus::Pending => 'warning',
                        KycStatus::Approved => 'success',
                        KycStatus::Rejected => 'danger',
                        default => 'gray',
                    })
                    ->searchable(query: function (Builder $query, string $search): Builder {
                        return $query->whereHas('userReviewApplications', function (Builder $query) use ($search): void {
                            $query->where('kyc_type', KycType::Driver->value)
                                ->whereIn('kyc_status', self::matchingKycStatusValues($search));
                        });
                    }),
                TextColumn::make('driverProfile.vehicleTypeRef.name_vi')
                    ->label('Loại xe')
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('driverProfile.vehicle_number')
                    ->label('Biển số')
                    ->searchable()
                    ->toggleable(),
            ])
            ->filters([
                SelectFilter::make('is_active')
                    ->label('Trạng thái tài khoản')
                    ->options([
                        1 => 'Active',
                        0 => 'Locked',
                    ]),
                SelectFilter::make('approval_status')
                    ->label('Trạng thái duyệt')
                    ->options(self::kycStatusOptions())
                    ->query(function (Builder $query, array $data): Builder {
                        if (! filled($data['value'] ?? null)) {
                            return $query;
                        }

                        return $query->whereHas('userReviewApplications', function (Builder $query) use ($data): void {
                            $query->where('kyc_type', KycType::Driver->value)
                                ->where('kyc_status', (int) $data['value']);
                        });
                    }),
            ])
            ->emptyStateIcon(Heroicon::OutlinedUsers)
            ->emptyStateHeading('Hiện chưa có tài xế nào.')
            ->emptyStateDescription('Không tìm thấy tài xế.')
            ->recordActions([
                ViewAction::make()
                    ->label('Xem chi tiết')
                    ->url(fn (User $record): string => DriverManagementResource::getUrl('view', ['record' => $record])),
                DriverManagementActions::approve(),
                DriverManagementActions::reject(),
                DriverManagementActions::lock(),
                DriverManagementActions::unlock(),
                DriverManagementActions::assignGroup(),
            ]);
    }

    private static function kycStatusOptions(): array
    {
        $options = [];

        foreach (KycStatus::cases() as $status) {
            $options[$status->value] = $status->label();
        }

        return $options;
    }

    private static function matchingKycStatusValues(string $search): array
    {
        $search = mb_strtolower(trim($search));

        return collect(KycStatus::cases())
            ->filter(fn (KycStatus $status): bool => str_contains(mb_strtolower($status->label()), $search))
            ->map(fn (KycStatus $status): int => $status->value)
            ->values()
            ->all();
    }
}
