<?php

namespace App\Filament\Clusters\DriverFinance;

use BackedEnum;
use Filament\Clusters\Cluster;
use Filament\Support\Icons\Heroicon;

class DriverFinanceCluster extends Cluster
{
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedBanknotes;

    public static function getNavigationGroup(): \UnitEnum|string|null
    {
        return 'Tài chính';
    }

    public static function getNavigationLabel(): string
    {
        return 'Tài chính tài xế';
    }

    public static function getClusterBreadcrumb(): ?string
    {
        return 'Tài chính tài xế';
    }
}
