<?php

namespace App\Filament\Clusters\Driver\Resources\DriverManagement\Schemas;

use App\Models\User\Enums\Gender;
use App\Models\User\Enums\KycStatus;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class DriverManagementInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Thông tin tài xế')
                    ->schema([
                        Grid::make(2)->schema([
                            TextEntry::make('full_name')
                                ->label('Họ và tên')
                                ->placeholder('Chưa cập nhật'),
                            TextEntry::make('phone')
                                ->label('Số điện thoại')
                                ->copyable()
                                ->placeholder('Chưa cập nhật'),
                            TextEntry::make('email')
                                ->label('Email')
                                ->copyable()
                                ->placeholder('Chưa cập nhật'),
                            TextEntry::make('gender')
                                ->label('Giới tính')
                                ->formatStateUsing(fn (?Gender $state): string => $state?->label() ?? 'Chưa cập nhật'),
                            TextEntry::make('address')
                                ->label('Địa chỉ')
                                ->placeholder('Chưa cập nhật')
                                ->columnSpanFull(),
                            TextEntry::make('created_at')
                                ->label('Ngày tạo tài khoản')
                                ->dateTime('d/m/Y H:i'),
                        ]),
                    ]),

                Section::make('Thông tin phương tiện')
                    ->schema([
                        Grid::make(2)->schema([
                            TextEntry::make('driverProfile.vehicleTypeRef.name_vi')
                                ->label('Loại phương tiện')
                                ->placeholder('Chưa cập nhật'),
                            TextEntry::make('driverProfile.vehicle_number')
                                ->label('Biển số xe')
                                ->placeholder('Chưa cập nhật'),
                            TextEntry::make('driverProfile.vehicle_name')
                                ->label('Tên xe')
                                ->placeholder('Chưa cập nhật'),
                            TextEntry::make('driverProfile.license_number')
                                ->label('Số GPLX')
                                ->placeholder('Chưa cập nhật'),
                        ]),
                    ]),

                Section::make('Trạng thái')
                    ->schema([
                        Grid::make(2)->schema([
                            TextEntry::make('is_active')
                                ->label('Trạng thái tài khoản')
                                ->badge()
                                ->formatStateUsing(fn (bool $state): string => $state ? 'Active' : 'Locked')
                                ->color(fn (bool $state): string => $state ? 'success' : 'danger'),
                            TextEntry::make('latestDriverApplication.kyc_status')
                                ->label('Trạng thái duyệt')
                                ->badge()
                                ->formatStateUsing(fn (?KycStatus $state): string => $state?->label() ?? KycStatus::NotSubmitted->label())
                                ->color(fn (?KycStatus $state): string => match ($state) {
                                    KycStatus::Pending => 'warning',
                                    KycStatus::Approved => 'success',
                                    KycStatus::Rejected => 'danger',
                                    default => 'gray',
                                }),
                            TextEntry::make('latestDriverApplication.cancel_reason')
                                ->label('Lý do từ chối')
                                ->placeholder('Không có')
                                ->columnSpanFull(),
                            TextEntry::make('lock_reason')
                                ->label('Lý do khóa')
                                ->placeholder('Không có')
                                ->columnSpanFull(),
                            TextEntry::make('lock_expired_at')
                                ->label('Mở khóa lúc')
                                ->dateTime('d/m/Y H:i')
                                ->placeholder('Không có'),
                        ]),
                    ]),
            ]);
    }
}
