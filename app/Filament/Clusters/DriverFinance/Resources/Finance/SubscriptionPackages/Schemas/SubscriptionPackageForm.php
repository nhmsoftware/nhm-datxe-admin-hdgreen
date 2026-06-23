<?php

namespace App\Filament\Clusters\DriverFinance\Resources\Finance\SubscriptionPackages\Schemas;

use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class SubscriptionPackageForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Thông tin gói thuê bao')
                    ->description('Áp dụng cho tài xế đối tác. Runtime hiện dùng service fee reduction, không có cơ chế full fare riêng.')
                    ->schema([
                        Grid::make(2)->schema([
                            TextInput::make('name')
                                ->label('Tên gói')
                                ->required()
                                ->maxLength(100)
                                ->validationMessages([
                                    'required' => 'Vui lòng nhập đầy đủ thông tin gói thuê bao.',
                                ]),
                            Select::make('package_type')
                                ->label('Loại gói')
                                ->options([
                                    'daily' => 'Hàng ngày',
                                    'weekly' => 'Hàng tuần',
                                    'monthly' => 'Hàng tháng',
                                ])
                                ->required()
                                ->native(false),
                            TextInput::make('price')
                                ->label('Giá gói')
                                ->numeric()
                                ->required()
                                ->minValue(0.01)
                                ->suffix('VND')
                                ->validationMessages([
                                    'required' => 'Vui lòng nhập đầy đủ thông tin gói thuê bao.',
                                    'min' => 'Giá gói thuê bao không hợp lệ.',
                                    'numeric' => 'Giá gói thuê bao không hợp lệ.',
                                ]),
                            TextInput::make('duration_days')
                                ->label('Thời hạn (ngày)')
                                ->integer()
                                ->required()
                                ->minValue(1)
                                ->validationMessages([
                                    'required' => 'Vui lòng nhập đầy đủ thông tin gói thuê bao.',
                                    'min' => 'Thời hạn gói thuê bao không hợp lệ.',
                                    'integer' => 'Thời hạn gói thuê bao không hợp lệ.',
                                ]),
                            TextInput::make('service_fee_reduction_percent')
                                ->label('Giảm phí dịch vụ (%)')
                                ->numeric()
                                ->minValue(0)
                                ->maxValue(100)
                                ->default(0)
                                ->helperText('0 = không giảm, 100 = miễn toàn bộ phí dịch vụ')
                                ->validationMessages([
                                    'min' => 'Mức giảm phí dịch vụ không hợp lệ.',
                                    'max' => 'Mức giảm phí dịch vụ không hợp lệ.',
                                    'numeric' => 'Mức giảm phí dịch vụ không hợp lệ.',
                                ]),
                            Toggle::make('is_active')
                                ->label('Đang mở bán')
                                ->default(true),
                            Placeholder::make('benefit_note')
                                ->label('Ghi chú nghiệp vụ')
                                ->content('Gói đang hoạt động cho phép tài xế đối tác giảm phí dịch vụ theo tỷ lệ cấu hình. Khi vô hiệu hóa, tài xế đang sử dụng vẫn giữ hiệu lực đến hết hạn.'),
                            Textarea::make('description')
                                ->label('Mô tả / Benefits')
                                ->rows(4)
                                ->maxLength(500)
                                ->columnSpanFull(),
                        ]),
                    ]),
            ]);
    }
}
