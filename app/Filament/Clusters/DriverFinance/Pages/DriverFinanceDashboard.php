<?php

namespace App\Filament\Clusters\DriverFinance\Pages;

use App\Filament\Clusters\DriverFinance\DriverFinanceCluster;
use App\Filament\Clusters\DriverFinance\Resources\Finance\DriverCommissionRules\DriverCommissionRuleResource;
use App\Filament\Clusters\DriverFinance\Resources\Finance\SubscriptionPackages\SubscriptionPackageResource;
use App\Models\Finance\CommissionRule;
use App\Models\Ride\Ride;
use App\Models\User\DriverProfile;
use App\Models\User\Enums\DriverGroupType;
use App\Models\User\Enums\DriverStatus;
use Filament\Pages\Page;
use Filament\Support\Icons\Heroicon;

class DriverFinanceDashboard extends Page
{
    protected string $view = 'filament.clusters.driver-finance.pages.driver-finance-dashboard';

    protected static ?string $cluster = DriverFinanceCluster::class;

    protected static string|\BackedEnum|null $navigationIcon = Heroicon::OutlinedPresentationChartBar;

    protected static ?string $navigationLabel = 'Tổng quan';

    protected static ?string $slug = 'dashboard';

    public function getTitle(): string
    {
        return 'Tổng quan tài chính tài xế';
    }

    public function stats(): array
    {
        return [
            [
                'label' => 'Tổng tài xế',
                'value' => number_format(DriverProfile::query()->count()),
                'hint' => 'Tất cả hồ sơ tài xế',
            ],
            [
                'label' => 'Đội xe nhà',
                'value' => number_format(DriverProfile::query()->where('driver_group_type', DriverGroupType::INTERNAL->value)->count()),
                'hint' => 'Internal fleet',
            ],
            [
                'label' => 'Đối tác tự do',
                'value' => number_format(DriverProfile::query()->where('driver_group_type', DriverGroupType::PARTNER->value)->count()),
                'hint' => 'Partner freelance fleet',
            ],
            [
                'label' => 'Doanh thu hoàn thành',
                'value' => number_format((float) Ride::query()->where('status', \App\Models\Ride\Enums\RideStatus::COMPLETED->value)->sum('total_price'), 0, ',', '.') . ' VND',
                'hint' => 'Tổng doanh thu ride hoàn thành',
            ],
            [
                'label' => 'Tổng hoa hồng',
                'value' => number_format((float) Ride::query()->where('status', \App\Models\Ride\Enums\RideStatus::COMPLETED->value)->sum('service_fee'), 0, ',', '.') . ' VND',
                'hint' => 'System commission thực thu',
            ],
            [
                'label' => 'Khóa nhận cuốc',
                'value' => number_format(DriverProfile::query()->where('status', DriverStatus::DISPATCH_LOCKED->value)->count()),
                'hint' => 'Dispatch locked drivers',
            ],
        ];
    }

    public function commissionSummary(): array
    {
        $driverTarget = \App\Models\Finance\Enums\CommissionTargetType::DRIVER->value;

        return CommissionRule::query()
            ->where('target_type', $driverTarget)
            ->where('is_active', true)
            ->orderBy('service_type')
            ->get()
            ->map(fn (CommissionRule $rule): array => [
                'service' => $rule->service_type?->getLabel() ?? 'Không xác định',
                'rate' => number_format((float) $rule->commission_rate, 2),
                'scope' => $rule->scope?->getLabel() ?? 'Không xác định',
            ])
            ->toArray();
    }

    public function menuOptions(): array
    {
        return [
            [
                'label' => 'Cấu hình ví tín dụng',
                'description' => 'Quản lý ngưỡng số dư tối thiểu, tự động khóa nhận cuốc và rule áp dụng cho tài xế đối tác.',
                'url' => ManageCreditWalletConfig::getUrl(),
            ],
            [
                'label' => 'Gói thuê bao',
                'description' => 'Tạo, cập nhật và vô hiệu hóa gói thuê bao dành cho tài xế đối tác.',
                'url' => SubscriptionPackageResource::getUrl('index'),
            ],
            [
                'label' => 'Mô hình hoa hồng',
                'description' => 'Quản lý cấu hình hoa hồng cho tài xế theo loại dịch vụ và phạm vi áp dụng.',
                'url' => DriverCommissionRuleResource::getUrl('index'),
            ],
        ];
    }
}
