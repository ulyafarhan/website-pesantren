<?php

namespace App\Filament\Widgets;

use App\Models\Article;
use App\Models\ClassProgram;
use App\Models\Facility;
use App\Models\Gallery;
use App\Models\Registration;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\Cache;

class StatsOverviewWidget extends BaseWidget
{
    protected ?string $pollingInterval = '60s';

    protected function getStats(): array
    {
        $stats = Cache::remember('dashboard_stats', 300, function () {
            return [
                'articles' => Article::where('is_published', true)->count(),
                'galleries' => Gallery::count(),
                'facilities' => Facility::count(),
                'programs' => ClassProgram::count(),
                'total_registrations' => Registration::count(),
                'pending_registrations' => Registration::where('status', 'PENDING')->count(),
            ];
        });

        return [
            Stat::make('Artikel Publik', $stats['articles'])
                ->description('Artikel & berita live')
                ->descriptionIcon('heroicon-m-document-text')
                ->color('success'),

            Stat::make('Galeri', $stats['galleries'])
                ->description('Dokumentasi foto')
                ->descriptionIcon('heroicon-m-photo')
                ->color('info'),

            Stat::make('Pendaftar Baru', $stats['pending_registrations'])
                ->description('Menunggu verifikasi')
                ->descriptionIcon('heroicon-m-academic-cap')
                ->color('warning'),

            Stat::make('Program Kelas', $stats['programs'])
                ->description('Program aktif')
                ->descriptionIcon('heroicon-m-building-library')
                ->color('primary'),
        ];
    }
}