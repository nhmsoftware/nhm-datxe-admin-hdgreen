<?php

namespace App\Filament\Clusters\Driver\Resources\DriverReviewApplications\Schemas;

use App\Models\Driver\Enums\KycStatus;
use App\Models\Driver\Enums\KycType;
use Filament\Forms\Components\KeyValue;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class DriverReviewApplicationForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Thông tin hồ sơ')
                    ->schema([
                        Grid::make(2)->schema([
                            Select::make('user_id')
                                ->label('Tài khoản')
                                ->relationship('user', 'phone')
                                ->searchable()
                                ->preload()
                                ->required(),
                            Select::make('kyc_type')
                                ->label('Loại hồ sơ')
                                ->options(self::enumOptions(KycType::cases(), 'getLabel'))
                                ->native(false)
                                ->required(),
                            Select::make('kyc_status')
                                ->label('Trạng thái duyệt')
                                ->options(self::enumOptions(KycStatus::cases(), 'getLabel'))
                                ->native(false)
                                ->required(),
                            Textarea::make('cancel_reason')
                                ->label('Lý do từ chối/hủy')
                                ->rows(3)
                                ->columnSpanFull(),
                        ]),
                    ]),

                Section::make('Dữ liệu snapshot')
                    ->schema([
                        KeyValue::make('snapshot_data')
                            ->label('Snapshot')
                            ->keyLabel('Trường')
                            ->valueLabel('Giá trị')
                            ->columnSpanFull(),
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
