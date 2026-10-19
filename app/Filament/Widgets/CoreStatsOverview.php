<?php

namespace App\Filament\Widgets;

use App\Models\Order;
use App\Models\Product;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class CoreStatsOverview extends StatsOverviewWidget
{
    protected ?string $heading = null;

    protected function getColumns(): int
    {
        return 4;
    }

    protected function getStats(): array
    {
        return [
            Stat::make(
                'Total Pesanan',
                Order::count()
            )
                ->description('Seluruh pesanan yang tercatat')
                ->descriptionIcon('heroicon-m-shopping-bag')
                ->color('primary'),

            Stat::make(
                'Total Pembayaran Terverifikasi',
                'Rp ' . number_format(
                    (float) Order::where('payment_status', 'paid')->sum('total'),
                    0,
                    ',',
                    '.'
                )
            )
                ->description('Total nilai pesanan berstatus paid')
                ->descriptionIcon('heroicon-m-banknotes')
                ->color('success'),

            Stat::make(
                'Belum Dibayar',
                Order::where('payment_status', 'unpaid')->count()
            )
                ->description('Pesanan yang belum lunas')
                ->descriptionIcon('heroicon-m-clock')
                ->color('warning'),

            Stat::make(
                'Total Produk',
                Product::count()
            )
                ->description('Produk yang tercatat di katalog')
                ->descriptionIcon('heroicon-m-cube')
                ->color('info'),
        ];
    }
}