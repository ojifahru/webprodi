<?php

namespace App\Filament\Widgets;

use App\Models\Lecturer;
use App\Models\News;
use App\Models\StudyProgram;
use App\Models\User;
use Filament\Support\Enums\IconPosition;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class GlobalStats extends StatsOverviewWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Total Lecturers', Lecturer::count())
                ->description('Jumlah total dosen di sistem')
                ->descriptionIcon('heroicon-o-academic-cap', IconPosition::Before)
                ->color('primary'),
            Stat::make('Total Study Programs', StudyProgram::count())
                ->description('Jumlah total program studi di sistem')
                ->descriptionIcon('heroicon-o-user-group', IconPosition::Before)
                ->color('success'),
            Stat::make('Total News Articles', News::count())
                ->description('Jumlah total berita di sistem')
                ->descriptionIcon('heroicon-o-newspaper', IconPosition::Before)
                ->color('danger'),
            Stat::make('Total Admin', User::count())
                ->description('Jumlah total Admin di sistem')
                ->descriptionIcon('heroicon-o-users', IconPosition::Before)
                ->color('warning'),
        ];
    }
}
