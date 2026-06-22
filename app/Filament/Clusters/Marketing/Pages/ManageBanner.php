<?php

namespace App\Filament\Clusters\Marketing\Pages;

use App\Filament\Clusters\Marketing\MarketingCluster;
use App\Models\Marketing\Banner;
use App\Models\Marketing\Enums\MarketingItemStatus;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class ManageBanner extends Page
{
    protected string $view = 'filament.clusters.marketing.pages.manage-banner';

    protected static ?string $cluster = MarketingCluster::class;

    protected static string|\BackedEnum|null $navigationIcon = Heroicon::OutlinedPhoto;

    protected static ?string $navigationLabel = 'Banner';

    protected static ?string $slug = 'banner';

    public ?array $data = [];

    private ?Banner $banner = null;

    public function mount(): void
    {
        $this->banner = Banner::query()->oldest('id')->first();

        $this->form->fill([
            'image_url' => $this->banner?->raw_image_path,
            'tag' => $this->banner?->tag,
            'description' => $this->banner?->description,
            'title' => $this->banner?->title,
            'label' => $this->banner?->label,
            'status' => $this->banner?->status?->value ?? MarketingItemStatus::ACTIVE->value,
        ]);
    }

    public function getTitle(): string
    {
        return 'Quản lý banner';
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->statePath('data')
            ->components([
                Section::make('Thông tin banner')
                    ->schema([
                        Grid::make(2)->schema([
                            FileUpload::make('image_url')
                                ->label('Hình ảnh banner')
                                ->image()
                                ->disk('public')
                                ->directory('marketing/banners')
                                ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp'])
                                ->maxSize(5120)
                                ->required()
                                ->imagePreviewHeight('220')
                                ->validationMessages([
                                    'required' => 'Vui lòng bổ sung hình ảnh banner.',
                                    'image' => 'Hình ảnh không đúng định dạng hoặc vượt quá dung lượng cho phép.',
                                    'mimes' => 'Hình ảnh không đúng định dạng hoặc vượt quá dung lượng cho phép.',
                                    'mimetypes' => 'Hình ảnh không đúng định dạng hoặc vượt quá dung lượng cho phép.',
                                    'max' => 'Hình ảnh không đúng định dạng hoặc vượt quá dung lượng cho phép.',
                                ])
                                ->columnSpanFull(),
                            Select::make('tag')
                                ->label('Loại banner')
                                ->options([
                                    'home' => 'Trang chủ',
                                    'promotion' => 'Khuyến mãi',
                                    'announcement' => 'Thông báo',
                                ])
                                ->required()
                                ->native(false)
                                ->validationMessages([
                                    'required' => 'Vui lòng nhập đầy đủ thông tin.',
                                ]),
                            Select::make('status')
                                ->label('Trạng thái')
                                ->options(self::statusOptions())
                                ->default(MarketingItemStatus::ACTIVE->value)
                                ->native(false)
                                ->required(),
                            TextInput::make('title')
                                ->label('Tiêu đề')
                                ->maxLength(255),
                            TextInput::make('label')
                                ->label('Nhãn')
                                ->maxLength(255),
                            Textarea::make('description')
                                ->label('Mô tả')
                                ->rows(4)
                                ->required()
                                ->maxLength(1000)
                                ->validationMessages([
                                    'required' => 'Vui lòng nhập đầy đủ thông tin.',
                                ])
                                ->columnSpanFull(),
                        ]),
                    ]),
            ]);
    }

    public function save(): void
    {
        try {
            $data = $this->form->getState();

            DB::transaction(function () use ($data): void {
                $banner = Banner::query()->oldest('id')->first() ?? new Banner();

                $banner->fill([
                    'title' => $data['title'] ?? null,
                    'description' => $data['description'],
                    'label' => $data['label'] ?? null,
                    'tag' => $data['tag'],
                    'image_url' => $data['image_url'],
                    'status' => $data['status'],
                    'order' => 0,
                ]);

                $banner->save();

                Banner::query()
                    ->whereKeyNot($banner->getKey())
                    ->delete();
            });

            Notification::make()
                ->success()
                ->title('Cập nhật banner thành công.')
                ->send();
        } catch (ValidationException $exception) {
            throw $exception;
        } catch (\Throwable $exception) {
            report($exception);

            Notification::make()
                ->danger()
                ->title('Cập nhật banner thất bại.')
                ->send();
        }
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
