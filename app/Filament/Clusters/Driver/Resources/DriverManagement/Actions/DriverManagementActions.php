<?php

namespace App\Filament\Clusters\Driver\Resources\DriverManagement\Actions;

use App\Models\User;
use App\Models\User\DriverProfile;
use App\Models\User\Enums\DriverGroupType;
use App\Models\User\Enums\DriverStatus;
use App\Models\User\Enums\KycStatus;
use App\Models\User\Enums\KycType;
use App\Models\User\Enums\UserRole;
use App\Models\User\Enums\VehicleColor;
use Filament\Actions\Action;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Notifications\Notification;
use Filament\Support\Icons\Heroicon;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class DriverManagementActions
{
    public static function approve(): Action
    {
        return Action::make('approve_driver')
            ->label('Duyệt')
            ->icon(Heroicon::OutlinedCheckCircle)
            ->color('success')
            ->visible(fn (User $record): bool => self::latestDriverStatus($record) === KycStatus::Pending)
            ->requiresConfirmation()
            ->modalHeading('Duyệt hồ sơ tài xế')
            ->modalDescription('Hệ thống sẽ chuyển hồ sơ sang Đã duyệt và tạo hồ sơ vận hành nếu tài xế chưa có.')
            ->modalSubmitActionLabel('Duyệt tài xế')
            ->action(function (User $record): void {
                $application = self::latestDriverApplication($record);

                if ($application === null) {
                    Notification::make()->danger()->title('Tài xế không tồn tại.')->send();

                    return;
                }

                if ($application->kyc_status === KycStatus::Approved) {
                    Notification::make()->warning()->title('Tài xế đã được duyệt trước đó.')->send();

                    return;
                }

                if ($application->kyc_status !== KycStatus::Pending) {
                    Notification::make()->danger()->title('Hồ sơ tài xế đang không ở trạng thái chờ duyệt.')->send();

                    return;
                }

                DB::transaction(function () use ($record, $application): void {
                    $application->forceFill([
                        'kyc_status' => KycStatus::Approved->value,
                        'cancel_reason' => null,
                    ])->save();

                    $record->forceFill([
                        'role' => UserRole::Driver->value,
                    ])->save();

                    self::ensureDriverProfile($record);
                });

                Notification::make()->success()->title('Duyệt tài xế thành công.')->send();
            });
    }

    public static function reject(): Action
    {
        return Action::make('reject_driver')
            ->label('Từ chối')
            ->icon(Heroicon::OutlinedXCircle)
            ->color('danger')
            ->visible(fn (User $record): bool => self::latestDriverStatus($record) === KycStatus::Pending)
            ->modalHeading('Từ chối hồ sơ tài xế')
            ->modalSubmitActionLabel('Từ chối')
            ->schema([
                Textarea::make('reject_reason')
                    ->label('Lý do từ chối')
                    ->required()
                    ->rows(4)
                    ->maxLength(1000)
                    ->validationMessages([
                        'required' => 'Vui lòng nhập lý do từ chối.',
                    ]),
            ])
            ->action(function (User $record, array $data): void {
                $application = self::latestDriverApplication($record);

                if ($application === null) {
                    Notification::make()->danger()->title('Tài xế không tồn tại.')->send();

                    return;
                }

                if ($application->kyc_status !== KycStatus::Pending) {
                    Notification::make()->warning()->title('Hồ sơ tài xế đã được xử lý trước đó.')->send();

                    return;
                }

                $application->forceFill([
                    'kyc_status' => KycStatus::Rejected->value,
                    'cancel_reason' => $data['reject_reason'],
                ])->save();

                Notification::make()->success()->title('Từ chối tài xế thành công.')->send();
            });
    }

    public static function lock(): Action
    {
        return Action::make('lock_driver')
            ->label('Khóa tài khoản')
            ->icon(Heroicon::OutlinedLockClosed)
            ->color('danger')
            ->visible(fn (User $record): bool => $record->is_active)
            ->modalHeading('Khóa tài khoản tài xế')
            ->modalDescription('Nếu bỏ trống số ngày, hệ thống sẽ mặc định khóa 2 ngày.')
            ->modalSubmitActionLabel('Khóa tài khoản')
            ->schema([
                Textarea::make('reason')
                    ->label('Lý do khóa')
                    ->required()
                    ->rows(4)
                    ->maxLength(1000)
                    ->validationMessages([
                        'required' => 'Vui lòng nhập lý do khóa tài khoản.',
                    ]),
                TextInput::make('days')
                    ->label('Số ngày khóa')
                    ->numeric()
                    ->minValue(1)
                    ->default(2)
                    ->validationMessages([
                        'min' => 'Số ngày khóa không hợp lệ.',
                        'numeric' => 'Số ngày khóa không hợp lệ.',
                    ]),
            ])
            ->action(function (User $record, array $data): void {
                if (! $record->is_active) {
                    self::alreadySameStateNotification();

                    return;
                }

                $days = filled($data['days'] ?? null) ? (int) $data['days'] : 2;

                if ($days < 1) {
                    Notification::make()->danger()->title('Số ngày khóa không hợp lệ.')->send();

                    return;
                }

                $record->forceFill([
                    'is_active' => false,
                    'lock_reason' => $data['reason'],
                    'locked_days' => $days,
                    'locked_at' => Carbon::now(),
                    'lock_expired_at' => Carbon::now()->addDays($days),
                ])->save();

                Notification::make()->success()->title('Khóa tài khoản tài xế thành công.')->send();
            });
    }

    public static function unlock(): Action
    {
        return Action::make('unlock_driver')
            ->label('Mở khóa')
            ->icon(Heroicon::OutlinedLockOpen)
            ->color('success')
            ->visible(fn (User $record): bool => ! $record->is_active)
            ->requiresConfirmation()
            ->modalHeading('Mở khóa tài khoản tài xế')
            ->modalDescription('Bạn có chắc muốn mở khóa tài khoản tài xế này không?')
            ->modalSubmitActionLabel('Mở khóa')
            ->action(function (User $record): void {
                if ($record->is_active) {
                    self::alreadySameStateNotification();

                    return;
                }

                $record->forceFill([
                    'is_active' => true,
                    'lock_reason' => null,
                    'locked_days' => null,
                    'locked_at' => null,
                    'lock_expired_at' => null,
                ])->save();

                Notification::make()->success()->title('Mở khóa tài khoản tài xế thành công.')->send();
            });
    }

    public static function assignGroup(): Action
    {
        return Action::make('assign_group')
            ->label('Gán đội xe nhà')
            ->icon(Heroicon::OutlinedUserGroup)
            ->color('info')
            ->visible(fn (User $record): bool => $record->driverProfile !== null
                && (bool) $record->driverProfile->is_online
                && (int) $record->driverProfile->driver_group_type !== DriverGroupType::INTERNAL->value)
            ->requiresConfirmation()
            ->modalHeading('Gán tài xế vào đội xe nhà')
            ->modalDescription('Bạn có chắc muốn gán tài xế này vào đội xe nhà không?')
            ->modalSubmitActionLabel('Gán đội xe nhà')
            ->action(function (User $record): void {
                if ($record->driverProfile === null) {
                    Notification::make()->danger()->title('Tài xế không tồn tại.')->send();

                    return;
                }

                if (! $record->driverProfile->is_online) {
                    Notification::make()->danger()->title('Chỉ có thể gán tài xế đang online vào đội xe nhà.')->send();

                    return;
                }

                if ((int) $record->driverProfile->driver_group_type === DriverGroupType::INTERNAL->value) {
                    Notification::make()->warning()->title('Tài xế đã thuộc đội xe nhà.')->send();

                    return;
                }

                $record->driverProfile->forceFill([
                    'driver_group_type' => DriverGroupType::INTERNAL->value,
                ])->save();

                Notification::make()->success()->title('Gán tài xế vào đội xe nhà thành công.')->send();
            });
    }

    public static function latestDriverStatus(User $record): KycStatus
    {
        return self::latestDriverApplication($record)?->kyc_status ?? KycStatus::NotSubmitted;
    }

    private static function latestDriverApplication(User $record): ?\App\Models\User\UserReviewApplication
    {
        return $record->latestDriverApplication
            ?? $record->userReviewApplications()
                ->where('kyc_type', KycType::Driver->value)
                ->latest()
                ->first();
    }

    private static function ensureDriverProfile(User $record): DriverProfile
    {
        if ($record->driverProfile !== null) {
            return $record->driverProfile;
        }

        $application = self::latestDriverApplication($record);
        $snapshot = $application?->snapshot_data ?? [];

        return $record->driverProfile()->create([
            'full_name' => $snapshot['full_name'] ?? $record->full_name ?? 'Driver ' . $record->getKey(),
            'driver_group_type' => DriverGroupType::PARTNER->value,
            'vehicle_type' => (int) ($snapshot['vehicle_type_id'] ?? $snapshot['vehicle_type'] ?? 1),
            'vehicle_name' => $snapshot['vehicle_name'] ?? 'N/A',
            'vehicle_color' => VehicleColor::tryFrom((int) ($snapshot['vehicle_color'] ?? 0))?->value ?? VehicleColor::Unknown->value,
            'vehicle_number' => $snapshot['vehicle_number'] ?? 'N/A',
            'is_online' => false,
            'status' => DriverStatus::ACTIVE->value,
            'license_number' => $snapshot['license_number'] ?? ($snapshot['citizen_id'] ?? null),
        ]);
    }

    private static function alreadySameStateNotification(): void
    {
        Notification::make()
            ->warning()
            ->title('Trạng thái tài khoản đã được cập nhật trước đó.')
            ->send();
    }

}
