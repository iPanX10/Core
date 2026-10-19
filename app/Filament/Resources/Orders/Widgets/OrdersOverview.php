<?php

namespace App\Filament\Resources\Orders\Widgets;

use App\Models\Order;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class OrdersOverview extends StatsOverviewWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Total Pesanan', Order::count())
                ->description('Seluruh pesanan yang tercatat')
                ->descriptionIcon('heroicon-m-shopping-bag')
                ->color('primary'),

            Stat::make(
                'Menunggu',
                Order::where('status', 'pending')->count()
            )
                ->description('Pesanan menunggu tindak lanjut')
                ->descriptionIcon('heroicon-m-clock')
                ->color('warning'),

            Stat::make(
                'Belum Dibayar',
                Order::where('payment_status', 'unpaid')->count()
            )
                ->description('Menunggu konfirmasi pembayaran')
                ->descriptionIcon('heroicon-m-credit-card')
                ->color('danger'),

            Stat::make(
                'Selesai',
                Order::where('status', 'completed')->count()
            )
                ->description('Pesanan telah diselesaikan')
                ->descriptionIcon('heroicon-m-check-circle')
                ->color('success'),
        ];
    }
}