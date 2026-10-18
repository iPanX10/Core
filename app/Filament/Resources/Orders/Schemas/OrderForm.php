<?php

namespace App\Filament\Resources\Orders\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class OrderForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('order_number')
                    ->label('Nomor Pesanan')
                    ->required()
                    ->readOnly(),

                TextInput::make('customer_name')
                    ->label('Nama Pelanggan')
                    ->required()
                    ->readOnly(),

                TextInput::make('whatsapp')
                    ->label('WhatsApp')
                    ->required()
                    ->readOnly(),

                TextInput::make('fulfillment_method')
                    ->label('Metode Penerimaan')
                    ->formatStateUsing(fn (?string $state): string => match ($state) {
                        'delivery' => 'Pengiriman',
                        'pickup' => 'Ambil di Toko',
                        default => $state ?? '-',
                    })
                    ->readOnly(),

                Textarea::make('address')
                    ->label('Alamat Pengiriman')
                    ->readOnly()
                    ->visible(fn ($record): bool =>
                        $record?->fulfillment_method === 'delivery'
                    )
                    ->columnSpanFull(),

                TextInput::make('payment_method')
                    ->label('Metode Pembayaran')
                    ->formatStateUsing(fn (?string $state): string => match ($state) {
                        'bank_transfer' => 'Transfer Bank / Virtual Account',
                        'qris' => 'QRIS',
                        'ewallet' => 'E-Wallet',
                        default => $state ?? '-',
                    })
                    ->readOnly(),

                TextInput::make('payment_provider')
                    ->label('Penyedia Pembayaran')
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
                    ->readOnly(),

                TextInput::make('payment_account_number')
                    ->label('Nomor VA / E-Wallet Simulasi')
                    ->placeholder('Nomor belum tersedia')
                    ->readOnly()
                    ->visible(fn ($record): bool =>
                        in_array(
                            $record?->payment_method,
                            ['bank_transfer', 'ewallet'],
                            true
                        )
                    ),

                TextInput::make('payment_account_name')
                    ->label('Nama Penerima Simulasi')
                    ->placeholder('Nama belum tersedia')
                    ->readOnly()
                    ->visible(fn ($record): bool =>
                        in_array(
                            $record?->payment_method,
                            ['bank_transfer', 'ewallet'],
                            true
                        )
                    ),

                Select::make('status')
                    ->label('Status Pesanan')
                    ->options(fn ($record): array => (
                        $record?->fulfillment_method === 'pickup'
                            ? [
                                'pending' => 'Menunggu',
                                'processing' => 'Diproses',
                                'completed' => 'Selesai',
                                'cancelled' => 'Dibatalkan',
                            ]
                            : [
                                'pending' => 'Menunggu',
                                'processing' => 'Diproses',
                                'shipped' => 'Dikirim',
                                'completed' => 'Selesai',
                                'cancelled' => 'Dibatalkan',
                            ]
                    ))
                    ->rules(fn ($record): array => (
                        $record?->fulfillment_method === 'pickup'
                            ? ['not_in:shipped']
                            : []
                    ))
                    ->required()
                    ->native(false)
                    ->helperText(
                        'Pesanan ambil di toko tidak dapat menggunakan status Dikirim.'
                    ),

                Select::make('payment_status')
                    ->label('Status Pembayaran')
                    ->options([
                        'unpaid' => 'Belum Dibayar',
                        'paid' => 'Sudah Dibayar',
                    ])
                    ->required()
                    ->native(false)
                    ->helperText(
                        'Konfirmasi secara manual hanya setelah pembayaran diverifikasi.'
                    ),

                TextInput::make('total')
                    ->label('Total Pesanan (Rp)')
                    ->numeric()
                    ->prefix('Rp')
                    ->readOnly(),
            ]);
    }
}
