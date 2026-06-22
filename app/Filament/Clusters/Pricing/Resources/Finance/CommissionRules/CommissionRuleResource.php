<?php

namespace App\Filament\Clusters\Pricing\Resources\Finance\CommissionRules;

use App\Filament\Clusters\Pricing\PricingCluster;
use App\Filament\Clusters\Pricing\Resources\Finance\CommissionRules\Pages\CreateCommissionRule;
use App\Filament\Clusters\Pricing\Resources\Finance\CommissionRules\Pages\EditCommissionRule;
use App\Filament\Clusters\Pricing\Resources\Finance\CommissionRules\Pages\ListCommissionRules;
use App\Filament\Clusters\Pricing\Resources\Finance\CommissionRules\Schemas\CommissionRuleForm;
use App\Filament\Clusters\Pricing\Resources\Finance\CommissionRules\Tables\CommissionRulesTable;
use App\Models\Finance\CommissionRule;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CommissionRuleResource extends Resource
{
    protected static ?string $model = CommissionRule::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedReceiptPercent;

    protected static ?string $cluster = PricingCluster::class;

    protected static ?string $recordTitleAttribute = 'service_type';

    protected static ?string $slug = 'commission-rules';

    public static function getNavigationLabel(): string
    {
        return 'Hoa hồng';
    }

    public static function getModelLabel(): string
    {
        return 'Cấu hình hoa hồng';
    }

    public static function getPluralModelLabel(): string
    {
        return 'Cấu hình hoa hồng';
    }

    public static function form(Schema $schema): Schema
    {
        return CommissionRuleForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return CommissionRulesTable::configure($table);
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
            'index' => ListCommissionRules::route('/'),
            'create' => CreateCommissionRule::route('/create'),
            'edit' => EditCommissionRule::route('/{record}/edit'),
        ];
    }

    public static function getRecordRouteBindingEloquentQuery(): Builder
    {
        return parent::getRecordRouteBindingEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }

    public static function hasDuplicateActiveRule(array $data, ?string $exceptId = null): bool
    {
        if (! (bool) ($data['is_active'] ?? false)) {
            return false;
        }

        return CommissionRule::query()
            ->where('is_active', true)
            ->where('target_type', $data['target_type'] ?? null)
            ->where('service_type', $data['service_type'] ?? null)
            ->where('scope', $data['scope'] ?? null)
            ->where('area_id', $data['area_id'] ?? null)
            ->when($exceptId !== null, fn (Builder $query) => $query->whereKeyNot($exceptId))
            ->exists();
    }
}
