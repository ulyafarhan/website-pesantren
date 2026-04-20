<?php

namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;

class TrafficChartWidget extends ChartWidget
{
    protected ?string $heading = 'Grafik Pengunjung';

    protected static ?int $sort = 2;

    protected int|string|array $columnSpan = 'full';

    protected function getData(): array
    {
        return [
            'datasets' => [
                [
                    'label' => 'Kunjungan Harian',
                    'data' => [120, 240, 150, 300, 280, 400, 520, 480, 600, 550, 700, 680],
                    'backgroundColor' => 'rgba(16, 185, 129, 0.4)',
                    'borderColor' => '#10b981',
                    'tension' => 0.4,
                    'fill' => true,
                ],
            ],
            'labels' => [
                'Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun',
                'Jul', 'Ags', 'Sep', 'Okt', 'Nov', 'Des'
            ],
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
