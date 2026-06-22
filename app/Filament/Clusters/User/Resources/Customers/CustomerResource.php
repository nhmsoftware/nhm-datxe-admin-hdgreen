<?php

namespace App\Filament\Clusters\User\Resources\Customers;

use App\Filament\Clusters\User\UserCluster;
use App\Filament\Clusters\User\Resources\Customers\Pages\ListCustomers;
use App\Filament\Clusters\User\Resources\Customers\Pages\ViewCustomer;
use App\Filament\Clusters\User\Resources\Customers\Schemas\CustomerForm;
use App\Filament\Clusters\User\Resources\Customers\Schemas\CustomerInfolist;
use App\Filament\Clusters\User\Resources\Customers\Tables\CustomersTable;
use App\Models\User;
use App\Models\User\Enums\UserRole;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CustomerResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $cluster = UserCluster::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedUsers;

    protected static ?string $recordTitleAttribute = 'full_name';

    public static function getNavigationGroup(): \UnitEnum|string|null
    {
        return 'Người dùng';
    }

    public static function getNavigationLabel(): string
    {
        return 'Khách hàng';
    }

    public static function getModelLabel(): string
    {
        return 'Khách hàng';
    }

    public static function getPluralModelLabel(): string
    {
        return 'Khách hàng';
    }

    public static function form(Schema $schema): Schema
    {
        return CustomerForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return CustomerInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return CustomersTable::configure($table);
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
            'index' => ListCustomers::route('/'),
            'view' => ViewCustomer::route('/{record}'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->with('customerProfile')
            ->where('role', UserRole::Customer->value);
    }

    public static function getRecordRouteBindingEloquentQuery(): Builder
    {
        return parent::getRecordRouteBindingEloquentQuery()
            ->where('role', UserRole::Customer->value)
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
}
