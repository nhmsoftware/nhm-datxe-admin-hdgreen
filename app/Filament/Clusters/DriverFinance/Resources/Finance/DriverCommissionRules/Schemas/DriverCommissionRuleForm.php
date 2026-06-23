<?php

namespace App\Filament\Clusters\DriverFinance\Resources\Finance\DriverCommissionRules\Schemas;

use App\Models\Finance\Enums\CommissionScope;
use App\Models\Finance\Enums\CommissionServiceType;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class DriverCommissionRuleForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Cấu hình hoa hồng tài xế')
                    ->description('Giai đoạn này chỉ áp dụng cho tài xế. Merchant và food chưa mở trên UI nhưng vẫn được giữ khả năng mở rộng ở model.')
                    ->schema([
                        Grid::make(2)->schema([
                            TextInput::make('name')
                                ->label('Tên cấu hình')
                                ->maxLength(255),
                            Toggle::make('is_active')
                                ->label('Đang hoạt động')
                                ->default(true),
                            Placeholder::make('target_scope')
                                ->label('Đối tượng')
                                ->content('Tài xế')
                                ->dehydrated(false),
                            Select::make('service_type')
                                ->label('Loại dịch vụ')
                                ->options([
                                    CommissionServiceType::RIDE->value => CommissionServiceType::RIDE->getLabel(),
                                    CommissionServiceType::DELIVERY->value => CommissionServiceType::DELIVERY->getLabel(),
                                    CommissionServiceType::INTERCITY->value => CommissionServiceType::INTERCITY->getLabel(),
                                    CommissionServiceType::AIRPORT->value => CommissionServiceType::AIRPORT->getLabel(),
                                ])
                                ->required()
                                ->native(false)
                                ->validationMessages([
                                    'required' => 'Please Select Service Type.',
                                ]),
                            Select::make('scope')
                                ->label('Phạm vi')
                                ->options(self::scopeOptions())
                                ->required()
                                ->native(false),
                            TextInput::make('area_id')
                                ->label('Mã khu vực')
                                ->maxLength(255)
                                ->helperText('Để trống khi áp dụng toàn hệ thống.'),
                            TextInput::make('commission_rate')
                                ->label('Tỷ lệ hoa hồng (%)')
                                ->numeric()
                                ->required()
                                ->minValue(0.01)
                                ->maxValue(100)
                                ->validationMessages([
                                    'required' => 'Invalid Commission Rate.',
                                    'numeric' => 'Invalid Commission Rate.',
                                    'min' => 'Invalid Commission Rate.',
                                    'max' => 'Invalid Commission Rate.',
                                ]),
                            TextInput::make('min_commission')
                                ->label('Hoa hồng tối thiểu')
                                ->numeric()
                                ->minValue(0),
                            TextInput::make('max_commission')
                                ->label('Hoa hồng tối đa')
                                ->numeric()
                                ->minValue(0)
                                ->gte('min_commission'),
                            DateTimePicker::make('effective_from')
                                ->label('Hiệu lực từ')
                                ->required(),
                            DateTimePicker::make('effective_to')
                                ->label('Hiệu lực đến')
                                ->after('effective_from'),
                        ]),
                    ]),
            ]);
    }

    private static function scopeOptions(): array
    {
        $options = [];

        foreach (CommissionScope::cases() as $scope) {
            $options[$scope->value] = $scope->getLabel();
        }

        return $options;
    }
}
