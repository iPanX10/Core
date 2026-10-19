<?php

namespace App\Filament\Resources\Orders\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class OrderForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Informasi Pesanan')
                    ->description('Informasi utama pesanan pelanggan.')
                    ->columns(2)
                    ->schema([
                        TextInput::make('order_number')
                            ->label('Nomor Pesanan')
                            ->required()
                            ->readOnly()
                            ->copyable(),

                        TextInput::make('customer_name')
                            ->label('Nama Pelanggan')
                            ->required()
                            ->readOnly(),

                        TextInput::make('whatsapp')
                            ->label('Nomor WhatsApp')
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
                    ]),

                Section::make('Informasi Pengiriman')
                    ->description('Alamat tujuan pesanan pelanggan.')
                    ->schema([
                        Textarea::make('address')
                            ->label('Alamat Pengiriman')
                            ->readOnly()
                            ->rows(3)
                            ->visible(fn ($record): bool =>
                                $record?->fulfillment_method === 'delivery'
                            )
                            ->columnSpanFull(),
                    ])
                    ->visible(fn ($record): bool =>
                        $record?->fulfillment_method === 'delivery'
                    ),

                Section::make('Informasi Pembayaran')
                    ->description('Detail metode dan tujuan pembayaran simulasi.')
                    ->columns(2)
                    ->schema([
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
                            ->copyable()
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
                    ]),

                Section::make('Pengelolaan Pesanan')
                    ->description('Perbarui status pesanan setelah melakukan verifikasi.')
                    ->columns(2)
                    ->schema([
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
                                'Pilih Sudah Dibayar hanya setelah pembayaran diverifikasi.'
                            ),

                        TextInput::make('total')
                            ->label('Total Pesanan')
                            ->numeric()
                            ->prefix('Rp')
                            ->readOnly()
                            ->columnSpanFull(),
                    ]),
            ]);
    }
}