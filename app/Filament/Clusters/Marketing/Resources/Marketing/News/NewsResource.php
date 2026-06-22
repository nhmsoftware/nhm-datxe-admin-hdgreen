<?php

namespace App\Filament\Clusters\Marketing\Resources\Marketing\News;

use App\Filament\Clusters\Marketing\MarketingCluster;
use App\Filament\Clusters\Marketing\Resources\Marketing\News\Pages\CreateNews;
use App\Filament\Clusters\Marketing\Resources\Marketing\News\Pages\EditNews;
use App\Filament\Clusters\Marketing\Resources\Marketing\News\Pages\ListNews;
use App\Filament\Clusters\Marketing\Resources\Marketing\News\Schemas\NewsForm;
use App\Filament\Clusters\Marketing\Resources\Marketing\News\Tables\NewsTable;
use App\Models\Marketing\News;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class NewsResource extends Resource
{
    protected static ?string $model = News::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedNewspaper;

    protected static ?string $cluster = MarketingCluster::class;

    protected static ?string $recordTitleAttribute = 'title';

    protected static ?string $slug = 'news';

    public static function getNavigationLabel(): string
    {
        return 'Tin tức';
    }

    public static function getModelLabel(): string
    {
        return 'Tin tức';
    }

    public static function getPluralModelLabel(): string
    {
        return 'Tin tức';
    }

    public static function form(Schema $schema): Schema
    {
        return NewsForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return NewsTable::configure($table);
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
            'index' => ListNews::route('/'),
            'create' => CreateNews::route('/create'),
            'edit' => EditNews::route('/{record}/edit'),
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
