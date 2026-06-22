<?php

namespace App\Filament\Clusters\User\Resources\Customers\Schemas;

use App\Models\User\Enums\Gender;
use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class CustomerInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Thông tin khách hàng')
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

                Section::make('Trạng thái tài khoản')
                    ->schema([
                        Grid::make(2)->schema([
                            TextEntry::make('is_active')
                                ->label('Trạng thái')
                                ->badge()
                                ->formatStateUsing(fn (bool $state): string => $state ? 'Đang hoạt động' : 'Đã khóa')
                                ->color(fn (bool $state): string => $state ? 'success' : 'danger'),
                            IconEntry::make('is_phone_verified')
                                ->label('Đã xác thực SĐT')
                                ->boolean(),
                            TextEntry::make('lock_reason')
                                ->label('Lý do khóa')
                                ->placeholder('Không có')
                                ->columnSpanFull(),
                            TextEntry::make('locked_days')
                                ->label('Số ngày khóa')
                                ->placeholder('Không có'),
                            TextEntry::make('locked_at')
                                ->label('Khóa lúc')
                                ->dateTime('d/m/Y H:i')
                                ->placeholder('Không có'),
                            TextEntry::make('lock_expired_at')
                                ->label('Mở khóa lúc')
                                ->dateTime('d/m/Y H:i')
                                ->placeholder('Không có'),
                        ]),
                    ]),
            ]);
    }
}
