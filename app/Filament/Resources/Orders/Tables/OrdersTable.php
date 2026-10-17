<?php

namespace App\Filament\Resources\Orders\Tables;

use Filament\Actions\EditAction;
use Filament\Support\Enums\FontWeight;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class OrdersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('order_number')
                    ->label('Nomor Pesanan')
                    ->searchable()
                    ->copyable()
                    ->copyMessage('Nomor pesanan berhasil disalin')
                    ->weight(FontWeight::SemiBold),

                TextColumn::make('customer_name')
                    ->label('Pelanggan')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('whatsapp')
                    ->label('WhatsApp')
                    ->searchable()
                    ->toggleable(),

                TextColumn::make('fulfillment_method')
                    ->label('Metode Penerimaan')
                    ->formatStateUsing(fn (?string $state): string => match ($state) {
                        'delivery' => 'Pengiriman',
                        'pickup' => 'Ambil di Toko',
                        default => $state ?? '-',
                    })
                    ->badge()
                    ->color('gray'),

                TextColumn::make('payment_method')
                    ->label('Metode Pembayaran')
                    ->formatStateUsing(fn (?string $state): string => match ($state) {
                        'bank_transfer' => 'Transfer Bank / VA',
                        'qris' => 'QRIS',
                        'ewallet' => 'E-Wallet',
                        default => $state ?? '-',
                    })
                    ->badge()
                    ->color('gray'),

                TextColumn::make('payment_provider')
                    ->label('Penyedia')
                    ->formatStateUsing(fn (?string $state): string => match ($state) {
                        'bni' => 'BNI',
                        'bri' => 'BRI',
                        'mandiri' => 'Mandiri',
                        'bca' => 'BCA',
                        'qris' => 'QRIS',
                        'dana' => 'DANA',
                        'gopay' => 'GoPay',
                        'ovo' => 'OVO',
                        'shopeepay' => 'ShopeePay',
                        default => $state ? strtoupper($state) : '-',
                    })
                    ->badge()
                    ->color('gray')
                    ->toggleable(),

                TextColumn::make('payment_account_number')
                    ->label('Nomor Pembayaran Simulasi')
                    ->searchable()
                    ->copyable()
                    ->placeholder('Belum tersedia')
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('status')
                    ->label('Status Pesanan')
                    ->formatStateUsing(fn (?string $state): string => match ($state) {
                        'pending' => 'Menunggu',
                        'processing' => 'Diproses',
                        'shipped' => 'Dikirim',
                        'completed' => 'Selesai',
                        'cancelled' => 'Dibatalkan',
                        default => $state ?? '-',
                    })
                    ->badge()
                    ->color(fn (?string $state): string => match ($state) {
                        'pending' => 'warning',
                        'processing' => 'info',
                        'shipped' => 'primary',
                        'completed' => 'success',
                        'cancelled' => 'danger',
                        default => 'gray',
                    })
                    ->sortable(),

                TextColumn::make('payment_status')
                    ->label('Status Pembayaran')
                    ->formatStateUsing(fn (?string $state): string => match ($state) {
                        'unpaid' => 'Belum Dibayar',
                        'paid' => 'Sudah Dibayar',
                        default => $state ?? '-',
                    })
                    ->badge()
                    ->color(fn (?string $state): string => match ($state) {
                        'unpaid' => 'danger',
                        'paid' => 'success',
                        default => 'gray',
                    })
                    ->sortable(),

                TextColumn::make('total')
                    ->label('Total Pesanan')
                    ->money('IDR', locale: 'id')
                    ->weight(FontWeight::SemiBold)
                    ->sortable(),

                TextColumn::make('created_at')
                    ->label('Tanggal Pesanan')
                    ->dateTime('d M Y, H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([])
            ->recordActions([
                EditAction::make()
                    ->label('Kelola'),
            ])
            ->toolbarActions([]);
    }
}