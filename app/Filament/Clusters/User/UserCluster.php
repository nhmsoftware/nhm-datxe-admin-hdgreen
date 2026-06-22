<?php

namespace App\Filament\Clusters\User;

use BackedEnum;
use Filament\Clusters\Cluster;
use Filament\Support\Icons\Heroicon;

class UserCluster extends Cluster
{
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedUsers;

    public static function getNavigationGroup(): \UnitEnum|string|null
    {
        return 'Người dùng';
    }

    public static function getNavigationLabel(): string
    {
        return 'Quản lý người dùng';
    }

    public static function getClusterBreadcrumb(): ?string
    {
        return 'Quản lý người dùng';
    }
}
