<?php

namespace App\Filament\Admin\Resources\News\Pages;

use App\Filament\Admin\Resources\News\NewsResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Filament\Schemas\Components\Tabs\Tab;
use Illuminate\Database\Eloquent\Builder;

class ListNews extends ListRecords
{
    protected static string $resource = NewsResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }

    public function getTabs(): array
    {
        return [
            'all' => Tab::make('All News')
                ->icon('heroicon-o-newspaper')
                ->badge(fn () => $this->getModel()::count()),

            'published' => Tab::make('Published')
                ->icon('heroicon-o-check-circle')
                ->modifyQueryUsing(
                    fn (Builder $query) => $query->where('status', 'published')
                )
                ->badge(
                    fn () => $this->getModel()::where('status', 'published')->count()
                ),

            'draft' => Tab::make('Draft')
                ->icon('heroicon-o-document-text')
                ->modifyQueryUsing(
                    fn (Builder $query) => $query->where('status', 'draft')
                )
                ->badge(
                    fn () => $this->getModel()::where('status', 'draft')->count()
                ),
        ];
    }
}
