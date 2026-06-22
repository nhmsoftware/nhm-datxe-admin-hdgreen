<?php

namespace App\Filament\Clusters\Pricing\Resources\Pricing\PricingConfigs\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class PricingConfigForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Cấu hình giá theo loại xe')
                    ->schema([
                        Grid::make(2)->schema([
                            Select::make('vehicle_type_id')
                                ->label('Loại xe')
                                ->relationship('vehicleTypeRef', 'name_vi')
                                ->searchable()
                                ->preload()
                                ->required()
                                ->validationMessages([
                                    'required' => 'Vui lòng chọn loại xe.',
                                ]),
                            Toggle::make('is_active')
                                ->label('Đang hoạt động')
                                ->default(true),
                            TextInput::make('base_price')
                                ->label('Giá mở cửa')
                                ->numeric()
                                ->required()
                                ->minValue(0.01)
                                ->validationMessages([
                                    'required' => 'Giá mở cửa không hợp lệ.',
                                    'min' => 'Giá mở cửa không hợp lệ.',
                                    'numeric' => 'Giá mở cửa không hợp lệ.',
                                ]),
                            TextInput::make('min_fare')
                                ->label('Giá tối thiểu')
                                ->numeric()
                                ->required()
                                ->gte('base_price')
                                ->validationMessages([
                                    'required' => 'Giá tối thiểu không hợp lệ.',
                                    'gte' => 'Giá tối thiểu phải lớn hơn hoặc bằng giá mở cửa.',
                                    'numeric' => 'Giá tối thiểu không hợp lệ.',
                                ]),
                            TextInput::make('distance_rate')
                                ->label('Giá theo kilomet')
                                ->numeric()
                                ->required()
                                ->minValue(0.01)
                                ->validationMessages([
                                    'required' => 'Giá theo kilomet không hợp lệ.',
                                    'min' => 'Giá theo kilomet không hợp lệ.',
                                    'numeric' => 'Giá theo kilomet không hợp lệ.',
                                ]),
                            TextInput::make('time_rate')
                                ->label('Giá theo phút')
                                ->numeric()
                                ->required()
                                ->minValue(0.01)
                                ->validationMessages([
                                    'required' => 'Giá theo phút không hợp lệ.',
                                    'min' => 'Giá theo phút không hợp lệ.',
                                    'numeric' => 'Giá theo phút không hợp lệ.',
                                ]),
                            TextInput::make('surge_multiplier')
                                ->label('Hệ số tăng giá mặc định')
                                ->numeric()
                                ->default(1)
                                ->minValue(1),
                            TextInput::make('commission_rate')
                                ->label('Tỷ lệ hoa hồng (%)')
                                ->numeric()
                                ->minValue(0)
                                ->maxValue(100),
                        ]),
                    ]),
            ]);
    }
}
