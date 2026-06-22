<?php

namespace App\Filament\Clusters\Pricing\Resources\Finance\CommissionRules\Schemas;

use App\Models\Finance\Enums\CommissionScope;
use App\Models\Finance\Enums\CommissionServiceType;
use App\Models\Finance\Enums\CommissionTargetType;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class CommissionRuleForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Cấu hình hoa hồng')
                    ->schema([
                        Grid::make(2)->schema([
                            TextInput::make('name')
                                ->label('Tên cấu hình')
                                ->maxLength(255),
                            Toggle::make('is_active')
                                ->label('Đang hoạt động')
                                ->default(true),
                            Select::make('target_type')
                                ->label('Đối tượng')
                                ->options(self::targetTypeOptions())
                                ->required()
                                ->native(false)
                                ->validationMessages([
                                    'required' => 'Vui lòng chọn đối tượng hoa hồng.',
                                ]),
                            Select::make('service_type')
                                ->label('Loại hoa hồng')
                                ->options(self::serviceTypeOptions())
                                ->required()
                                ->native(false)
                                ->validationMessages([
                                    'required' => 'Vui lòng chọn loại hoa hồng cần cấu hình.',
                                ]),
                            Select::make('scope')
                                ->label('Phạm vi')
                                ->options(self::scopeOptions())
                                ->required()
                                ->native(false),
                            TextInput::make('area_id')
                                ->label('Mã khu vực')
                                ->maxLength(255),
                            TextInput::make('commission_rate')
                                ->label('Tỷ lệ hoa hồng (%)')
                                ->numeric()
                                ->required()
                                ->minValue(0)
                                ->maxValue(100)
                                ->validationMessages([
                                    'required' => 'Tỷ lệ hoa hồng không hợp lệ.',
                                    'min' => 'Tỷ lệ hoa hồng không hợp lệ.',
                                    'max' => 'Tỷ lệ hoa hồng không hợp lệ.',
                                    'numeric' => 'Tỷ lệ hoa hồng không hợp lệ.',
                                ]),
                            TextInput::make('min_commission')
                                ->label('Hoa hồng tối thiểu')
                                ->numeric()
                                ->minValue(0),
                            TextInput::make('max_commission')
                                ->label('Hoa hồng tối đa')
                                ->numeric()
                                ->minValue(0),
                            DateTimePicker::make('effective_from')
                                ->label('Hiệu lực từ'),
                            DateTimePicker::make('effective_to')
                                ->label('Hiệu lực đến')
                                ->after('effective_from'),
                        ]),
                    ]),
            ]);
    }

    private static function targetTypeOptions(): array
    {
        $options = [];

        foreach (CommissionTargetType::cases() as $type) {
            $options[$type->value] = $type->label();
        }

        return $options;
    }

    private static function serviceTypeOptions(): array
    {
        $options = [];

        foreach (CommissionServiceType::cases() as $type) {
            $options[$type->value] = $type->getLabel();
        }

        return $options;
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
