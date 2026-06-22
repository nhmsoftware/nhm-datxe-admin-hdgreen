<?php

namespace App\Filament\Clusters\Driver\Resources\DriverManagement\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class DriverManagementForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Thông tin tài xế')
                    ->schema([
                        Grid::make(2)->schema([
                            TextInput::make('name')
                                ->label('Họ và tên')
                                ->disabled(),
                            TextInput::make('phone')
                                ->label('Số điện thoại')
                                ->disabled(),
                            TextInput::make('email')
                                ->label('Email')
                                ->disabled(),
                        ]),
                    ]),
            ]);
    }
}
