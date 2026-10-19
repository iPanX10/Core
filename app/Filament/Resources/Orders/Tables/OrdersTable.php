<?php

namespace App\Filament\Resources\Orders\Tables;

use Filament\Actions\EditAction;
use Filament\Support\Enums\FontWeight;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class OrdersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('order_number')
                    ->label('No. Pesanan')
                    ->searchable()
                    ->copyable()
                    ->copyMessage('Nomor pesanan berhasil disalin')
                    ->weight(FontWeight::SemiBold)
                    ->color('primary'),

                TextColumn::make('customer_name')
                    ->label('Pelanggan')
                    ->searchable()
                    ->sortable()
                    ->weight(FontWeight::Medium),

                TextColumn::make('whatsapp')
                    ->label('WhatsApp')
                    ->searchable()
                    ->toggleable(),

                TextColumn::make('fulfillment_method')
                    ->label('Penerimaan')
                    ->formatStateUsing(fn (?string $state): string => match ($state) {
                        'delivery' => 'Pengiriman',
                        'pickup' => 'Ambil di Toko',
                        default => $state ?? '-',
                    })
                    ->badge()
                    ->color('gray')
                    ->sortable(),

                TextColumn::make('payment_method')
                    ->label('Pembayaran')
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
                    ->label('Nomor Pembayaran')
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
                    ->label('Pembayaran')
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
                    ->label('Total')
                    ->money('IDR', locale: 'id')
                    ->weight(FontWeight::SemiBold)
                    ->sortable(),

                TextColumn::make('created_at')
                    ->label('Tanggal')
                    ->dateTime('d M Y, H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->label('Status Pesanan')
                    ->options([
                        'pending' => 'Menunggu',
                        'processing' => 'Diproses',
                        'shipped' => 'Dikirim',
                        'completed' => 'Selesai',
                        'cancelled' => 'Dibatalkan',
                    ]),

                SelectFilter::make('payment_status')
                    ->label('Status Pembayaran')
                    ->options([
                        'unpaid' => 'Belum Dibayar',
                        'paid' => 'Sudah Dibayar',
                    ]),

                SelectFilter::make('fulfillment_method')
                    ->label('Metode Penerimaan')
                    ->options([
                        'pickup' => 'Ambil di Toko',
                        'delivery' => 'Pengiriman',
                    ]),
            ])
            ->recordActions([
                EditAction::make()
                    ->label('Kelola')
                    ->icon('heroicon-m-pencil-square'),
            ])
            ->toolbarActions([])
            ->defaultSort('created_at', 'desc');
    }
}