<?php

namespace App\Filament\Admin\Resources\News;

use App\Filament\Admin\Resources\News\Pages\CreateNews;
use App\Filament\Admin\Resources\News\Pages\EditNews;
use App\Filament\Admin\Resources\News\Pages\ListNews;
use App\Filament\Admin\Resources\News\Schemas\NewsForm;
use App\Filament\Admin\Resources\News\Tables\NewsTable;
use App\Models\News;
use BackedEnum;
use UnitEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;


class NewsResource extends Resource
{
    protected static ?string $model = News::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedNewspaper;
    protected static ?string $navigationLabel = 'Berita';
    protected static ?string $modelLabel = 'Berita';
    protected static ?string $pluralModelLabel = 'Berita';
    protected static ?int $navigationSort = 5;
    protected static string | UnitEnum | null $navigationGroup = 'Manajemen Konten';

    protected static ?string $recordTitleAttribute = 'title';

    public static function getEloquentQuery(): Builder
    {
        $query = parent::getEloquentQuery();

        if ($tenant = filament()->getTenant()) {
            $query->where('study_program_id', $tenant->getKey());
        }

        return $query;
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
}
