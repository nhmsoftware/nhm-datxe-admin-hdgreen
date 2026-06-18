<?php

namespace App\Filament\Clusters\Driver\Resources\DriverProfiles\Schemas;

use App\Models\User\Enums\DriverGroupType;
use App\Models\User\Enums\DriverStatus;
use App\Models\User\Enums\VehicleColor;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class DriverProfileForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Thông tin tài xế')
                    ->schema([
                        Grid::make(2)->schema([
                            Select::make('user_id')
                                ->label('Tài khoản')
                                ->relationship('user', 'phone')
                                ->searchable()
                                ->preload()
                                ->required(),
                            TextInput::make('full_name')
                                ->label('Họ và tên')
                                ->required()
                                ->maxLength(255),
                            Select::make('driver_group_id')
                                ->label('Nhóm tài xế')
                                ->relationship('driverGroup', 'name')
                                ->searchable()
                                ->preload(),
                            Select::make('driver_group_type')
                                ->label('Loại nhóm')
                                ->options(self::enumOptions(DriverGroupType::cases(), 'label'))
                                ->native(false),
                        ]),
                    ]),

                Section::make('Phương tiện')
                    ->schema([
                        Grid::make(2)->schema([
                            Select::make('vehicle_type')
                                ->label('Loại phương tiện')
                                ->relationship('vehicleTypeRef', 'name_vi')
                                ->searchable()
                                ->preload()
                                ->required(),
                            TextInput::make('vehicle_name')
                                ->label('Tên xe')
                                ->maxLength(255),
                            Select::make('vehicle_color')
                                ->label('Màu xe')
                                ->options(self::enumOptions(VehicleColor::cases(), 'label'))
                                ->native(false),
                            TextInput::make('vehicle_number')
                                ->label('Biển số xe')
                                ->maxLength(50),
                        ]),
                    ]),

                Section::make('Trạng thái vận hành')
                    ->schema([
                        Grid::make(3)->schema([
                            Select::make('status')
                                ->label('Trạng thái')
                                ->options(self::enumOptions(DriverStatus::cases(), 'getLabel'))
                                ->native(false)
                                ->required(),
                            Toggle::make('is_online')
                                ->label('Đang online'),
                            DateTimePicker::make('cooldown_until')
                                ->label('Đóng băng đến'),
                            TextInput::make('current_lat')
                                ->label('Vĩ độ hiện tại')
                                ->numeric(),
                            TextInput::make('current_lng')
                                ->label('Kinh độ hiện tại')
                                ->numeric(),
                            TextInput::make('cancel_count_today')
                                ->label('Số lần hủy hôm nay')
                                ->numeric()
                                ->minValue(0),
                        ]),
                    ]),

                Section::make('Giấy phép và ngân hàng')
                    ->schema([
                        Grid::make(2)->schema([
                            TextInput::make('license_number')
                                ->label('Số GPLX')
                                ->maxLength(100),
                            TextInput::make('license_front_image')
                                ->label('Ảnh GPLX mặt trước')
                                ->maxLength(255),
                            TextInput::make('license_back_image')
                                ->label('Ảnh GPLX mặt sau')
                                ->maxLength(255),
                            TextInput::make('bank_name')
                                ->label('Ngân hàng')
                                ->maxLength(255),
                            TextInput::make('bank_account_number')
                                ->label('Số tài khoản')
                                ->maxLength(100),
                            TextInput::make('bank_account_holder')
                                ->label('Chủ tài khoản')
                                ->maxLength(255),
                        ]),
                    ]),

                Section::make('Thống kê')
                    ->schema([
                        Grid::make(2)->schema([
                            TextInput::make('average_rating')
                                ->label('Điểm đánh giá')
                                ->numeric()
                                ->minValue(0)
                                ->maxValue(5),
                            TextInput::make('total_trips')
                                ->label('Tổng chuyến')
                                ->numeric()
                                ->minValue(0),
                        ]),
                    ]),
            ]);
    }

    private static function enumOptions(array $cases, string $labelMethod): array
    {
        $options = [];

        foreach ($cases as $case) {
            $options[$case->value] = $case->{$labelMethod}();
        }

        return $options;
    }
}
