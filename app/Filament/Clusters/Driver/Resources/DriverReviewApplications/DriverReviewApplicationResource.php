<?php

namespace App\Filament\Clusters\Driver\Resources\DriverReviewApplications;

use App\Filament\Clusters\Driver\DriverCluster;
use App\Filament\Clusters\Driver\Resources\DriverReviewApplications\Pages\CreateDriverReviewApplication;
use App\Filament\Clusters\Driver\Resources\DriverReviewApplications\Pages\EditDriverReviewApplication;
use App\Filament\Clusters\Driver\Resources\DriverReviewApplications\Pages\ListDriverReviewApplications;
use App\Filament\Clusters\Driver\Resources\DriverReviewApplications\Schemas\DriverReviewApplicationForm;
use App\Filament\Clusters\Driver\Resources\DriverReviewApplications\Tables\DriverReviewApplicationsTable;
use App\Models\Driver\UserReviewApplication;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class DriverReviewApplicationResource extends Resource
{
    protected static ?string $model = UserReviewApplication::class;

    protected static ?string $cluster = DriverCluster::class;

    public static function getNavigationGroup(): \UnitEnum|string|null
    {
        return 'Tài xế';
    }

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    public static function getNavigationLabel(): string
    {
        return 'Kiểm duyệt tài xế';
    }

    public static function getModelLabel(): string
    {
        return 'Hồ sơ kiểm duyệt';
    }

    public static function getPluralModelLabel(): string
    {
        return 'Hồ sơ kiểm duyệt';
    }

    public static function form(Schema $schema): Schema
    {
        return DriverReviewApplicationForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return DriverReviewApplicationsTable::configure($table);
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
            'index' => ListDriverReviewApplications::route('/'),
            'create' => CreateDriverReviewApplication::route('/create'),
            'edit' => EditDriverReviewApplication::route('/{record}/edit'),
        ];
    }
}
