<?php

namespace App\Filament\Clusters\Marketing\Resources\Marketing\News\Tables;

use App\Models\Marketing\Enums\MarketingItemStatus;
use App\Models\Marketing\News;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Actions\ForceDeleteBulkAction;
use Filament\Actions\RestoreBulkAction;
use Filament\Actions\Action;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;

class NewsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')
                    ->label('Tiêu đề')
                    ->searchable()
                    ->sortable(),
                ImageColumn::make('raw_image_path')
                    ->label('Hình ảnh')
                    ->disk('public')
                    ->square(),
                TextColumn::make('tag')
                    ->label('Loại tin tức')
                    ->badge()
                    ->formatStateUsing(fn (?string $state): string => match ($state) {
                        'promotion' => 'Khuyến mãi',
                        'announcement' => 'Thông báo',
                        'guide' => 'Hướng dẫn',
                        'news' => 'Tin tức',
                        default => $state ?? 'Chưa phân loại',
                    }),
                TextColumn::make('status')
                    ->label('Trạng thái')
                    ->badge()
                    ->formatStateUsing(fn (?MarketingItemStatus $state): string => $state?->getLabel() ?? 'Chưa xác định')
                    ->color(fn (?MarketingItemStatus $state): string => match ($state) {
                        MarketingItemStatus::ACTIVE => 'success',
                        MarketingItemStatus::INACTIVE => 'gray',
                        default => 'gray',
                    })
                    ->sortable(),
                TextColumn::make('updated_at')
                    ->label('Cập nhật')
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                TrashedFilter::make(),
            ])
            ->recordActions([
                Action::make('toggle_status')
                    ->label(fn (News $record): string => $record->status === MarketingItemStatus::ACTIVE ? 'Ẩn' : 'Hiển thị')
                    ->color(fn (News $record): string => $record->status === MarketingItemStatus::ACTIVE ? 'gray' : 'success')
                    ->requiresConfirmation()
                    ->action(function (News $record): void {
                        $record->forceFill([
                            'status' => $record->status === MarketingItemStatus::ACTIVE
                                ? MarketingItemStatus::INACTIVE->value
                                : MarketingItemStatus::ACTIVE->value,
                        ])->save();
                    }),
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                    ForceDeleteBulkAction::make(),
                    RestoreBulkAction::make(),
                ]),
            ]);
    }
}
