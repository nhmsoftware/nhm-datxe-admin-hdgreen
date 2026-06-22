<?php

namespace App\Filament\Clusters\Marketing;

use BackedEnum;
use Filament\Clusters\Cluster;
use Filament\Support\Icons\Heroicon;

class MarketingCluster extends Cluster
{
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedMegaphone;

    public static function getNavigationGroup(): \UnitEnum|string|null
    {
        return 'Nội dung';
    }

    public static function getNavigationLabel(): string
    {
        return 'Banner & Tin tức';
    }

    public static function getClusterBreadcrumb(): ?string
    {
        return 'Banner & Tin tức';
    }
}
