<?php

namespace App\Filament\Clusters\Pricing\Resources\Pricing\PricingConfigs;

use App\Filament\Clusters\Pricing\PricingCluster;
use App\Filament\Clusters\Pricing\Resources\Pricing\PricingConfigs\Pages\CreatePricingConfig;
use App\Filament\Clusters\Pricing\Resources\Pricing\PricingConfigs\Pages\EditPricingConfig;
use App\Filament\Clusters\Pricing\Resources\Pricing\PricingConfigs\Pages\ListPricingConfigs;
use App\Filament\Clusters\Pricing\Resources\Pricing\PricingConfigs\Schemas\PricingConfigForm;
use App\Filament\Clusters\Pricing\Resources\Pricing\PricingConfigs\Tables\PricingConfigsTable;
use App\Models\Pricing\PricingConfig;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class PricingConfigResource extends Resource
{
    protected static ?string $model = PricingConfig::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedBanknotes;

    protected static ?string $cluster = PricingCluster::class;

    protected static ?string $recordTitleAttribute = 'vehicle_type_id';

    protected static ?string $slug = 'configs';

    public static function getNavigationLabel(): string
    {
        return 'Giá cơ bản';
    }

    public static function getModelLabel(): string
    {
        return 'Cấu hình giá';
    }

    public static function getPluralModelLabel(): string
    {
        return 'Cấu hình giá';
    }

    public static function form(Schema $schema): Schema
    {
        return PricingConfigForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return PricingConfigsTable::configure($table);
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
            'index' => ListPricingConfigs::route('/'),
            'create' => CreatePricingConfig::route('/create'),
            'edit' => EditPricingConfig::route('/{record}/edit'),
        ];
    }
}
