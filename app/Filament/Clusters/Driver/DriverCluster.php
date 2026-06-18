<?php

namespace App\Filament\Clusters\Driver;

use BackedEnum;
use Filament\Clusters\Cluster;
use Filament\Support\Icons\Heroicon;

class DriverCluster extends Cluster
{
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedSquares2x2;
    public static function getNavigationGroup(): \UnitEnum|string|null
    {
        return 'Tài xế';
    }

    public static function getNavigationLabel(): string
    {
        return 'Quản lý tài xế';
    }


    public static function getClusterBreadcrumb(): ?string
    {
        return 'Quản lý tài xế';
    }
}
