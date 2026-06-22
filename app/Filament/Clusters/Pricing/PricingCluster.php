<?php

namespace App\Filament\Clusters\Pricing;

use BackedEnum;
use Filament\Clusters\Cluster;
use Filament\Support\Icons\Heroicon;

class PricingCluster extends Cluster
{
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedBanknotes;

    public static function getNavigationGroup(): \UnitEnum|string|null
    {
        return 'Cấu hình';
    }

    public static function getNavigationLabel(): string
    {
        return 'Cấu hình giá';
    }

    public static function getClusterBreadcrumb(): ?string
    {
        return 'Cấu hình giá';
    }
}
