<?php

namespace App\Filament\Widgets;

use App\Models\Order;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\DB;

class SalesChart extends ChartWidget
{
    protected ?string $heading = 'Tren Pendapatan CORE';

    protected ?string $maxHeight = '320px';

    protected int|string|array $columnSpan = 2;

    protected function getData(): array
    {
        $orders = Order::query()
            ->selectRaw('DATE(created_at) as tanggal')
            ->selectRaw('SUM(total) as pendapatan')
            ->where('payment_status', 'paid')
            ->where(
                'created_at',
                '>=',
                now()->subDays(6)->startOfDay()
            )
            ->groupBy(DB::raw('DATE(created_at)'))
            ->orderBy('tanggal')
            ->get()
            ->keyBy('tanggal');

        $labels = [];
        $data = [];

        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subDays($i);
            $tanggal = $date->toDateString();

            $labels[] = $date->format('d M');

            $data[] = (float) (
                $orders->get($tanggal)?->pendapatan ?? 0
            );
        }

        return [
            'datasets' => [
                [
                    'label' => 'Pendapatan (Rp)',
                    'data' => $data,
                    'borderColor' => '#7C3AED',
                    'backgroundColor' => 'rgba(124, 58, 237, 0.18)',
                    'pointBackgroundColor' => '#8B5CF6',
                    'pointBorderColor' => '#FFFFFF',
                    'pointHoverBackgroundColor' => '#A78BFA',
                    'fill' => true,
                    'tension' => 0.4,
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}