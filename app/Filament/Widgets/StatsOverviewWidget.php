<?php

namespace App\Filament\Widgets;

use App\Models\Article;
use App\Models\Gallery;
use App\Models\Facility;
use App\Models\ClassProgram;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverviewWidget extends BaseWidget
{
    protected static ?int $sort = 1;

    // Filament 5: pollingInterval harus non-static
    protected ?string $pollingInterval = '10s';

    protected function getStats(): array
    {
        return [
            Stat::make('Total Artikel', Article::count())
                ->description('Artikel & berita publik')
                ->descriptionIcon('heroicon-m-document-text')
                ->color('success'),

            Stat::make('Total Galeri', Gallery::count())
                ->description('Dokumentasi foto')
                ->descriptionIcon('heroicon-m-photo')
                ->color('info'),

            Stat::make('Fasilitas', Facility::count())
                ->description('Infrastruktur pesantren')
                ->descriptionIcon('heroicon-m-building-office')
                ->color('warning'),

            Stat::make('Program Kelas', ClassProgram::count())
                ->description('Program akademik aktif')
                ->descriptionIcon('heroicon-m-academic-cap')
                ->color('primary'),
        ];
    }
}
