<?php

namespace App\Filament\Clusters\DriverFinance\Resources\Finance\SubscriptionPackages;

use App\Filament\Clusters\DriverFinance\DriverFinanceCluster;
use App\Filament\Clusters\DriverFinance\Resources\Finance\SubscriptionPackages\Pages\CreateSubscriptionPackage;
use App\Filament\Clusters\DriverFinance\Resources\Finance\SubscriptionPackages\Pages\EditSubscriptionPackage;
use App\Filament\Clusters\DriverFinance\Resources\Finance\SubscriptionPackages\Pages\ListSubscriptionPackages;
use App\Filament\Clusters\DriverFinance\Resources\Finance\SubscriptionPackages\RelationManagers\DriverSubscriptionsRelationManager;
use App\Filament\Clusters\DriverFinance\Resources\Finance\SubscriptionPackages\Schemas\SubscriptionPackageForm;
use App\Filament\Clusters\DriverFinance\Resources\Finance\SubscriptionPackages\Tables\SubscriptionPackagesTable;
use App\Models\Finance\SubscriptionPackage;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class SubscriptionPackageResource extends Resource
{
    protected static ?string $model = SubscriptionPackage::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedTicket;

    protected static ?string $cluster = DriverFinanceCluster::class;

    protected static ?string $recordTitleAttribute = 'name';

    protected static ?string $slug = 'subscription-packages';

    public static function getNavigationLabel(): string
    {
        return 'Gói thuê bao';
    }

    public static function getModelLabel(): string
    {
        return 'Gói thuê bao';
    }

    public static function getPluralModelLabel(): string
    {
        return 'Gói thuê bao';
    }

    public static function form(Schema $schema): Schema
    {
        return SubscriptionPackageForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return SubscriptionPackagesTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            DriverSubscriptionsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListSubscriptionPackages::route('/'),
            'create' => CreateSubscriptionPackage::route('/create'),
            'edit' => EditSubscriptionPackage::route('/{record}/edit'),
        ];
    }

    public static function getRecordRouteBindingEloquentQuery(): Builder
    {
        return parent::getRecordRouteBindingEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
}
