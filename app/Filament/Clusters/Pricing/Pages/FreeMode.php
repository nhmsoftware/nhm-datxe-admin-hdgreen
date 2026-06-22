<?php

namespace App\Filament\Clusters\Pricing\Pages;

use App\Filament\Clusters\Pricing\PricingCluster;
use App\Models\Pricing\PricingGlobalSetting;
use Filament\Actions\Action;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Support\Icons\Heroicon;

class FreeMode extends Page
{
    protected string $view = 'filament.clusters.pricing.pages.free-mode';

    protected static ?string $cluster = PricingCluster::class;

    protected static string|\BackedEnum|null $navigationIcon = Heroicon::OutlinedGift;

    protected static ?string $navigationLabel = 'Free Mode';

    public PricingGlobalSetting $setting;

    public function mount(): void
    {
        $this->setting = PricingGlobalSetting::query()->firstOrCreate([], [
            'is_free_mode' => false,
            'auto_push_internal' => false,
        ]);
    }

    public function getTitle(): string
    {
        return 'Chế độ miễn phí';
    }

    protected function getHeaderActions(): array
    {
        return [
            Action::make('toggle_free_mode')
                ->label($this->setting->is_free_mode ? 'Tắt Free Mode' : 'Bật Free Mode')
                ->icon($this->setting->is_free_mode ? Heroicon::OutlinedXCircle : Heroicon::OutlinedCheckCircle)
                ->color($this->setting->is_free_mode ? 'gray' : 'success')
                ->requiresConfirmation()
                ->modalHeading($this->setting->is_free_mode ? 'Tắt Free Mode' : 'Bật Free Mode')
                ->modalDescription($this->setting->is_free_mode
                    ? 'Hệ thống sẽ khôi phục cấu hình hoa hồng hiện hành.'
                    : 'Hệ thống sẽ áp dụng chế độ miễn phí, hoa hồng được xem là 0 trong runtime.')
                ->modalSubmitActionLabel('Xác nhận')
                ->action(function (): void {
                    try {
                        $this->setting->forceFill([
                            'is_free_mode' => ! $this->setting->is_free_mode,
                        ])->save();

                        $this->setting->refresh();

                        Notification::make()
                            ->success()
                            ->title('Cập nhật chế độ miễn phí thành công.')
                            ->send();
                    } catch (\Throwable) {
                        Notification::make()
                            ->danger()
                            ->title('Không thể cập nhật chế độ miễn phí. Vui lòng thử lại.')
                            ->send();
                    }
                }),
        ];
    }
}
