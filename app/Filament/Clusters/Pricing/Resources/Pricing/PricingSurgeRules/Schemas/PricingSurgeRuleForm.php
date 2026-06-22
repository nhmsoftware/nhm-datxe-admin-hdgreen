<?php

namespace App\Filament\Clusters\Pricing\Resources\Pricing\PricingSurgeRules\Schemas;

use Filament\Forms\Components\CheckboxList;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\TimePicker;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class PricingSurgeRuleForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Cấu hình giá giờ cao điểm')
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
                            TextInput::make('multiplier')
                                ->label('Hệ số tăng giá')
                                ->numeric()
                                ->required()
                                ->minValue(1.01)
                                ->validationMessages([
                                    'required' => 'Hệ số tăng giá không hợp lệ.',
                                    'min' => 'Hệ số tăng giá không hợp lệ.',
                                    'numeric' => 'Hệ số tăng giá không hợp lệ.',
                                ]),
                            CheckboxList::make('conditions')
                                ->label('Điều kiện áp dụng')
                                ->options([
                                    'rush_hour' => 'Giờ cao điểm',
                                    'bad_weather' => 'Thời tiết xấu',
                                ])
                                ->required()
                                ->columns(2)
                                ->validationMessages([
                                    'required' => 'Vui lòng chọn ít nhất một điều kiện áp dụng.',
                                ]),
                            Toggle::make('is_active')
                                ->label('Đang hoạt động')
                                ->default(true),
                            TimePicker::make('start_time')
                                ->label('Giờ bắt đầu')
                                ->seconds(false)
                                ->required()
                                ->before('end_time')
                                ->validationMessages([
                                    'required' => 'Khung thời gian áp dụng không hợp lệ.',
                                    'before' => 'Khung thời gian áp dụng không hợp lệ.',
                                ]),
                            TimePicker::make('end_time')
                                ->label('Giờ kết thúc')
                                ->seconds(false)
                                ->required()
                                ->after('start_time')
                                ->validationMessages([
                                    'required' => 'Khung thời gian áp dụng không hợp lệ.',
                                    'after' => 'Khung thời gian áp dụng không hợp lệ.',
                                ]),
                            Select::make('area_scope')
                                ->label('Phạm vi khu vực')
                                ->options([
                                    'all' => 'Toàn hệ thống',
                                    'district' => 'Quận/Huyện',
                                    'ward' => 'Phường/Xã',
                                ])
                                ->default('all')
                                ->dehydrated(false)
                                ->native(false),
                            TextInput::make('area_id')
                                ->label('Mã khu vực')
                                ->helperText('Để trống nếu áp dụng toàn hệ thống.')
                                ->maxLength(255),
                        ]),
                    ]),
            ]);
    }
}
