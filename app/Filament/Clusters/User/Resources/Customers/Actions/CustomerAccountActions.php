<?php

namespace App\Filament\Clusters\User\Resources\Customers\Actions;

use App\Models\User;
use Filament\Actions\Action;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Notifications\Notification;
use Filament\Support\Icons\Heroicon;
use Illuminate\Support\Carbon;

class CustomerAccountActions
{
    public static function lock(): Action
    {
        return Action::make('lock_user')
            ->label('Khóa tài khoản')
            ->icon(Heroicon::OutlinedLockClosed)
            ->color('danger')
            ->visible(fn (User $record): bool => $record->is_active)
            ->modalHeading('Khóa tài khoản khách hàng')
            ->modalDescription('Nhập lý do khóa và thời hạn khóa tài khoản. Nếu bỏ trống số ngày, hệ thống sẽ mặc định khóa 2 ngày.')
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
                    self::alreadyUpdatedNotification();

                    return;
                }

                $days = filled($data['days'] ?? null) ? (int) $data['days'] : 2;

                if ($days < 1) {
                    Notification::make()
                        ->danger()
                        ->title('Số ngày khóa không hợp lệ.')
                        ->send();

                    return;
                }

                $record->forceFill([
                    'is_active' => false,
                    'lock_reason' => $data['reason'],
                    'locked_days' => $days,
                    'locked_at' => Carbon::now(),
                    'lock_expired_at' => Carbon::now()->addDays($days),
                ])->save();

                Notification::make()
                    ->success()
                    ->title('Khóa tài khoản thành công.')
                    ->send();
            });
    }

    public static function unlock(): Action
    {
        return Action::make('unlock_user')
            ->label('Mở khóa')
            ->icon(Heroicon::OutlinedLockOpen)
            ->color('success')
            ->visible(fn (User $record): bool => ! $record->is_active)
            ->requiresConfirmation()
            ->modalHeading('Mở khóa tài khoản khách hàng')
            ->modalDescription('Bạn có chắc muốn mở khóa tài khoản này không?')
            ->modalSubmitActionLabel('Mở khóa')
            ->action(function (User $record): void {
                if ($record->is_active) {
                    self::alreadyUpdatedNotification();

                    return;
                }

                $record->forceFill([
                    'is_active' => true,
                    'lock_reason' => null,
                    'locked_days' => null,
                    'locked_at' => null,
                    'lock_expired_at' => null,
                ])->save();

                Notification::make()
                    ->success()
                    ->title('Mở khóa tài khoản thành công.')
                    ->send();
            });
    }

    private static function alreadyUpdatedNotification(): void
    {
        Notification::make()
            ->warning()
            ->title('Trạng thái tài khoản đã được cập nhật trước đó.')
            ->send();
    }
}
