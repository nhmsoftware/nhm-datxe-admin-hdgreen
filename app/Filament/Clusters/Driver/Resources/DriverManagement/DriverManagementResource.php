<?php

namespace App\Filament\Clusters\Driver\Resources\DriverManagement;

use App\Filament\Clusters\Driver\DriverCluster;
use App\Filament\Clusters\Driver\Resources\DriverManagement\Pages\ListDriverManagement;
use App\Filament\Clusters\Driver\Resources\DriverManagement\Pages\ViewDriverManagement;
use App\Filament\Clusters\Driver\Resources\DriverManagement\Schemas\DriverManagementForm;
use App\Filament\Clusters\Driver\Resources\DriverManagement\Schemas\DriverManagementInfolist;
use App\Filament\Clusters\Driver\Resources\DriverManagement\Tables\DriverManagementTable;
use App\Models\User;
use App\Models\User\Enums\UserRole;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class DriverManagementResource extends Resource
{
    protected static ?string $model = User::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedUsers;

    protected static ?string $cluster = DriverCluster::class;

    protected static ?string $recordTitleAttribute = 'full_name';

    public static function getNavigationLabel(): string
    {
        return 'Quản lý tài xế';
    }

    public static function getModelLabel(): string
    {
        return 'Tài xế';
    }

    public static function getPluralModelLabel(): string
    {
        return 'Tài xế';
    }

    public static function form(Schema $schema): Schema
    {
        return DriverManagementForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return DriverManagementInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return DriverManagementTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListDriverManagement::route('/'),
            'view' => ViewDriverManagement::route('/{record}'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->with(['driverProfile.vehicleTypeRef', 'driverProfile.driverGroup', 'latestDriverApplication'])
            ->where('role', UserRole::Driver->value);
    }

    public static function getRecordRouteBindingEloquentQuery(): Builder
    {
        return parent::getRecordRouteBindingEloquentQuery()
            ->where('role', UserRole::Driver->value)
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
}
