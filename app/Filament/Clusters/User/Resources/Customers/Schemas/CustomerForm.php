<?php

namespace App\Filament\Clusters\User\Resources\Customers\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class CustomerForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Thông tin khách hàng')
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
