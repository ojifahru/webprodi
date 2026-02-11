<?php

namespace App\Filament\Admin\Widgets;

use Filament\Facades\Filament;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class ProdiStats extends StatsOverviewWidget
{
    protected function getStats(): array
    {
        $tenant = Filament::getTenant();

        if (! $tenant) {
            return [];
        }

        return [
            Stat::make('Dosen', $tenant->lecturers()->count())
                ->description('Total dosen program studi')
                ->icon('heroicon-o-user-group')
                ->color('primary'),

            Stat::make('Berita', $tenant->news()->count())
                ->description('Total artikel berita')
                ->icon('heroicon-o-newspaper')
                ->color('info'),

            Stat::make('Kategori', $tenant->categories()->count())
                ->description('Kategori konten')
                ->icon('heroicon-o-rectangle-stack')
                ->color('success'),

            Stat::make('Tag', $tenant->tags()->count())
                ->description('Label / tag konten')
                ->icon('heroicon-o-tag')
                ->color('warning'),
        ];
    }
}
