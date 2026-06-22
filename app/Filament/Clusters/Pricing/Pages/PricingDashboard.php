<?php

namespace App\Filament\Clusters\Pricing\Pages;

use App\Filament\Clusters\Pricing\PricingCluster;
use App\Filament\Clusters\Pricing\Resources\Finance\CommissionRules\CommissionRuleResource;
use App\Filament\Clusters\Pricing\Resources\Pricing\PricingConfigs\PricingConfigResource;
use App\Filament\Clusters\Pricing\Resources\Pricing\PricingSurgeRules\PricingSurgeRuleResource;
use Filament\Pages\Page;
use Filament\Support\Icons\Heroicon;

class PricingDashboard extends Page
{
    protected string $view = 'filament.clusters.pricing.pages.pricing-dashboard';

    protected static ?string $cluster = PricingCluster::class;

    protected static string|\BackedEnum|null $navigationIcon = Heroicon::OutlinedCalculator;

    protected static ?string $navigationLabel = 'Tổng quan giá';

    protected static ?string $slug = 'dashboard';

    public function getTitle(): string
    {
        return 'Cấu hình giá';
    }

    public function menuOptions(): array
    {
        return [
            [
                'label' => 'Giá mở cửa, tối thiểu, theo km/phút',
                'description' => 'Thiết lập base price, minimum fare, price per km và price per minute theo loại xe.',
                'url' => PricingConfigResource::getUrl('index'),
            ],
            [
                'label' => 'Giá giờ cao điểm',
                'description' => 'Thiết lập điều kiện rush hour, bad weather, hệ số tăng giá và khung giờ áp dụng.',
                'url' => PricingSurgeRuleResource::getUrl('index'),
            ],
            [
                'label' => 'Hoa hồng',
                'description' => 'Cấu hình tỷ lệ hoa hồng theo loại dịch vụ và đối tượng.',
                'url' => CommissionRuleResource::getUrl('index'),
            ],
            [
                'label' => 'Free Mode',
                'description' => 'Bật/tắt chế độ miễn phí, runtime commission rate được xem là 0 khi bật.',
                'url' => FreeMode::getUrl(),
            ],
        ];
    }
}
