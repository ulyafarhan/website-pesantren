<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class SystemInfoWidget extends BaseWidget
{
    protected static ?int $sort = 3;

    protected ?string $pollingInterval = '60s';

    protected function getStats(): array
    {
        $diskFree = round(@disk_free_space('/') / 1024 / 1024 / 1024, 2);
        $diskTotal = round(@disk_total_space('/') / 1024 / 1024 / 1024, 2);
        $memoryUsage = round(memory_get_usage(true) / 1024 / 1024, 2);

        return [
            Stat::make('Sisa Penyimpanan (Disk)', "{$diskFree} GB / {$diskTotal} GB")
                ->description('Kapasitas server tersisa')
                ->descriptionIcon('heroicon-m-server')
                ->color($diskFree < 5 ? 'danger' : 'success'),

            Stat::make('Penggunaan Memori (PHP)', "{$memoryUsage} MB")
                ->description('Alokasi RAM aplikasi')
                ->descriptionIcon('heroicon-m-cpu-chip')
                ->color('info'),

            Stat::make('Versi PHP', phpversion())
                ->description('Mesin backend saat ini')
                ->descriptionIcon('heroicon-m-code-bracket-square'),
        ];
    }
}
