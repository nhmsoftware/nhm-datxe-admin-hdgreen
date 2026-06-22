<?php

namespace App\Filament\Clusters\Marketing\Resources\Marketing\News\Schemas;

use App\Models\Marketing\Enums\MarketingItemStatus;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\ToggleButtons;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class NewsForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Thông tin tin tức')
                    ->schema([
                        Grid::make(2)->schema([
                            TextInput::make('title')
                                ->label('Tiêu đề')
                                ->required()
                                ->maxLength(255)
                                ->validationMessages([
                                    'required' => 'Vui lòng nhập tiêu đề.',
                                ]),
                            Select::make('tag')
                                ->label('Loại tin tức')
                                ->options([
                                    'promotion' => 'Khuyến mãi',
                                    'announcement' => 'Thông báo',
                                    'guide' => 'Hướng dẫn',
                                    'news' => 'Tin tức',
                                ])
                                ->required()
                                ->native(false),
                            FileUpload::make('image_url')
                                ->label('Hình ảnh')
                                ->image()
                                ->disk('public')
                                ->directory('marketing/news')
                                ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp'])
                                ->maxSize(5120)
                                ->imagePreviewHeight('180')
                                ->validationMessages([
                                    'image' => 'Hình ảnh không đúng định dạng hoặc vượt quá dung lượng cho phép.',
                                    'mimes' => 'Hình ảnh không đúng định dạng hoặc vượt quá dung lượng cho phép.',
                                    'mimetypes' => 'Hình ảnh không đúng định dạng hoặc vượt quá dung lượng cho phép.',
                                    'max' => 'Hình ảnh không đúng định dạng hoặc vượt quá dung lượng cho phép.',
                                ])
                                ->columnSpanFull(),
                            Textarea::make('description')
                                ->label('Mô tả ngắn')
                                ->rows(3)
                                ->maxLength(1000)
                                ->columnSpanFull(),
                            RichEditor::make('content')
                                ->label('Nội dung')
                                ->required()
                                ->validationMessages([
                                    'required' => 'Vui lòng nhập nội dung.',
                                ])
                                ->columnSpanFull(),
                            TextInput::make('order')
                                ->label('Thứ tự')
                                ->numeric()
                                ->default(0),
                            ToggleButtons::make('status')
                                ->label('Trạng thái hiển thị')
                                ->options(self::statusOptions())
                                ->colors([
                                    MarketingItemStatus::ACTIVE->value => 'success',
                                    MarketingItemStatus::INACTIVE->value => 'gray',
                                ])
                                ->default(MarketingItemStatus::INACTIVE->value)
                                ->inline()
                                ->required(),
                        ]),
                    ]),
            ]);
    }

    private static function statusOptions(): array
    {
        $options = [];

        foreach (MarketingItemStatus::cases() as $status) {
            $options[$status->value] = $status->getLabel();
        }

        return $options;
    }
}
