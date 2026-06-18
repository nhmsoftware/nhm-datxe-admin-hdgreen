<?php

namespace App\Filament\Clusters\Driver\Resources\DriverProfiles;

use App\Filament\Clusters\Driver\DriverCluster;
use App\Filament\Clusters\Driver\Resources\DriverProfiles\Pages\CreateDriverProfile;
use App\Filament\Clusters\Driver\Resources\DriverProfiles\Pages\EditDriverProfile;
use App\Filament\Clusters\Driver\Resources\DriverProfiles\Pages\ListDriverProfiles;
use App\Filament\Clusters\Driver\Resources\DriverProfiles\Schemas\DriverProfileForm;
use App\Filament\Clusters\Driver\Resources\DriverProfiles\Tables\DriverProfilesTable;
use App\Models\User\DriverProfile;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class DriverProfileResource extends Resource
{
    protected static ?string $model = DriverProfile::class;

    protected static ?string $cluster = DriverCluster::class;

    public static function getNavigationGroup(): \UnitEnum|string|null
    {
        return 'Tài xế';
    }

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'full_name';

    public static function getNavigationLabel(): string
    {
        return 'Hồ sơ tài xế';
    }

    public static function getModelLabel(): string
    {
        return 'Hồ sơ tài xế';
    }

    public static function getPluralModelLabel(): string
    {
        return 'Hồ sơ tài xế';
    }

    public static function form(Schema $schema): Schema
    {
        return DriverProfileForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return DriverProfilesTable::configure($table);
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
            'index' => ListDriverProfiles::route('/'),
            'create' => CreateDriverProfile::route('/create'),
            'edit' => EditDriverProfile::route('/{record}/edit'),
        ];
    }
}
