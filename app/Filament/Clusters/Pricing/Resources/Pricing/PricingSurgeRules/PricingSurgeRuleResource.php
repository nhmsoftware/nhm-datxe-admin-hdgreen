<?php

namespace App\Filament\Clusters\Pricing\Resources\Pricing\PricingSurgeRules;

use App\Filament\Clusters\Pricing\PricingCluster;
use App\Filament\Clusters\Pricing\Resources\Pricing\PricingSurgeRules\Pages\CreatePricingSurgeRule;
use App\Filament\Clusters\Pricing\Resources\Pricing\PricingSurgeRules\Pages\EditPricingSurgeRule;
use App\Filament\Clusters\Pricing\Resources\Pricing\PricingSurgeRules\Pages\ListPricingSurgeRules;
use App\Filament\Clusters\Pricing\Resources\Pricing\PricingSurgeRules\Schemas\PricingSurgeRuleForm;
use App\Filament\Clusters\Pricing\Resources\Pricing\PricingSurgeRules\Tables\PricingSurgeRulesTable;
use App\Models\Pricing\PricingSurgeRule;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class PricingSurgeRuleResource extends Resource
{
    protected static ?string $model = PricingSurgeRule::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedArrowTrendingUp;

    protected static ?string $cluster = PricingCluster::class;

    protected static ?string $recordTitleAttribute = 'vehicle_type_id';

    protected static ?string $slug = 'surge-rules';

    public static function getNavigationLabel(): string
    {
        return 'Giá giờ cao điểm';
    }

    public static function getModelLabel(): string
    {
        return 'Cấu hình giá giờ cao điểm';
    }

    public static function getPluralModelLabel(): string
    {
        return 'Cấu hình giá giờ cao điểm';
    }

    public static function form(Schema $schema): Schema
    {
        return PricingSurgeRuleForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return PricingSurgeRulesTable::configure($table);
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
            'index' => ListPricingSurgeRules::route('/'),
            'create' => CreatePricingSurgeRule::route('/create'),
            'edit' => EditPricingSurgeRule::route('/{record}/edit'),
        ];
    }
}
