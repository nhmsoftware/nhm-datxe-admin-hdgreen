<?php

namespace App\Filament\Clusters\User\Resources\Customers\Tables;

use App\Filament\Clusters\User\Resources\Customers\Actions\CustomerAccountActions;
use App\Filament\Clusters\User\Resources\Customers\CustomerResource;
use App\Models\User;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class CustomersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('full_name')
                    ->label('Họ và tên')
                    ->searchable(['name'])
                    ->sortable(query: fn ($query, string $direction) => $query->orderBy('name', $direction))
                    ->placeholder('Chưa cập nhật'),
                TextColumn::make('phone')
                    ->label('Số điện thoại')
                    ->searchable()
                    ->copyable()
                    ->placeholder('Chưa cập nhật'),
                TextColumn::make('email')
                    ->label('Email')
                    ->searchable()
                    ->copyable()
                    ->placeholder('Chưa cập nhật'),
                TextColumn::make('is_active')
                    ->label('Trạng thái')
                    ->badge()
                    ->formatStateUsing(fn (bool $state): string => $state ? 'Đang hoạt động' : 'Đã khóa')
                    ->color(fn (bool $state): string => $state ? 'success' : 'danger')
                    ->sortable(),
                TextColumn::make('lock_expired_at')
                    ->label('Mở khóa lúc')
                    ->dateTime('d/m/Y H:i')
                    ->placeholder('Không có')
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('created_at')
                    ->label('Ngày tạo')
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->toggleable(),
            ])
            ->filters([
                SelectFilter::make('is_active')
                    ->label('Trạng thái')
                    ->options([
                        1 => 'Đang hoạt động',
                        0 => 'Đã khóa',
                    ]),
            ])
            ->recordActions([
                ViewAction::make()
                    ->label('Xem chi tiết')
                    ->url(fn (User $record): string => CustomerResource::getUrl('view', ['record' => $record])),
                CustomerAccountActions::lock(),
                CustomerAccountActions::unlock(),
            ]);
    }
}
