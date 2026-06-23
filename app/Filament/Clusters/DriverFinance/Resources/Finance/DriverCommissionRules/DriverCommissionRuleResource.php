<?php

namespace App\Filament\Clusters\DriverFinance\Resources\Finance\DriverCommissionRules;

use App\Filament\Clusters\DriverFinance\DriverFinanceCluster;
use App\Filament\Clusters\DriverFinance\Resources\Finance\DriverCommissionRules\Pages\CreateDriverCommissionRule;
use App\Filament\Clusters\DriverFinance\Resources\Finance\DriverCommissionRules\Pages\EditDriverCommissionRule;
use App\Filament\Clusters\DriverFinance\Resources\Finance\DriverCommissionRules\Pages\ListDriverCommissionRules;
use App\Filament\Clusters\DriverFinance\Resources\Finance\DriverCommissionRules\Schemas\DriverCommissionRuleForm;
use App\Filament\Clusters\DriverFinance\Resources\Finance\DriverCommissionRules\Tables\DriverCommissionRulesTable;
use App\Models\Finance\CommissionRule;
use App\Models\Finance\Enums\CommissionTargetType;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class DriverCommissionRuleResource extends Resource
{
    protected static ?string $model = CommissionRule::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedReceiptPercent;

    protected static ?string $cluster = DriverFinanceCluster::class;

    protected static ?string $recordTitleAttribute = 'name';

    protected static ?string $slug = 'driver-commission-rules';

    public static function getNavigationLabel(): string
    {
        return 'Mô hình hoa hồng';
    }

    public static function getModelLabel(): string
    {
        return 'Cấu hình hoa hồng tài xế';
    }

    public static function getPluralModelLabel(): string
    {
        return 'Cấu hình hoa hồng tài xế';
    }

    public static function form(Schema $schema): Schema
    {
        return DriverCommissionRuleForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return DriverCommissionRulesTable::configure($table);
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
            'index' => ListDriverCommissionRules::route('/'),
            'create' => CreateDriverCommissionRule::route('/create'),
            'edit' => EditDriverCommissionRule::route('/{record}/edit'),
        ];
    }

    public static function getRecordRouteBindingEloquentQuery(): Builder
    {
        return parent::getRecordRouteBindingEloquentQuery()
            ->where('target_type', CommissionTargetType::DRIVER->value)
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->where('target_type', CommissionTargetType::DRIVER->value);
    }

    public static function hasOverlappingActiveRule(array $data, ?string $exceptId = null): bool
    {
        if (! (bool) ($data['is_active'] ?? false)) {
            return false;
        }

        $query = CommissionRule::query()
            ->where('target_type', CommissionTargetType::DRIVER->value)
            ->where('service_type', $data['service_type'] ?? null)
            ->where('scope', $data['scope'] ?? null)
            ->where('is_active', true);

        $areaId = $data['area_id'] ?? null;

        if (filled($areaId)) {
            $query->where('area_id', $areaId);
        } else {
            $query->whereNull('area_id');
        }

        if ($exceptId !== null) {
            $query->whereKeyNot($exceptId);
        }

        $effectiveFrom = $data['effective_from'] ?? null;
        $effectiveTo = $data['effective_to'] ?? null;

        return $query
            ->where(function (Builder $query) use ($effectiveFrom, $effectiveTo): void {
                $query->where(function (Builder $inner) use ($effectiveFrom): void {
                    $inner->where('effective_from', '<=', $effectiveFrom)
                        ->where(function (Builder $sub) use ($effectiveFrom): void {
                            $sub->whereNull('effective_to')
                                ->orWhere('effective_to', '>=', $effectiveFrom);
                        });
                });

                if (filled($effectiveTo)) {
                    $query->orWhere(function (Builder $inner) use ($effectiveTo): void {
                        $inner->where('effective_from', '<=', $effectiveTo)
                            ->where(function (Builder $sub) use ($effectiveTo): void {
                                $sub->whereNull('effective_to')
                                    ->orWhere('effective_to', '>=', $effectiveTo);
                            });
                    })->orWhere(function (Builder $inner) use ($effectiveFrom, $effectiveTo): void {
                        $inner->where('effective_from', '>=', $effectiveFrom)
                            ->where('effective_from', '<=', $effectiveTo);
                    });
                }
            })
            ->exists();
    }
}
