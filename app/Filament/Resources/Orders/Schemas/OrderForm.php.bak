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
                    ->label('Metode Pengambilan')
                    ->required()
                    ->readOnly(),

                Textarea::make('address')
                    ->label('Alamat Pengiriman')
                    ->readOnly()
                    ->columnSpanFull(),

                TextInput::make('payment_method')
                    ->label('Metode Pembayaran')
                    ->required()
                    ->readOnly(),

                Select::make('status')
                    ->label('Status Pesanan')
                    ->options([
                        'pending' => 'Pending',
                        'processing' => 'Diproses',
                        'shipped' => 'Dikirim',
                        'completed' => 'Selesai',
                        'cancelled' => 'Dibatalkan',
                    ])
                    ->required()
                    ->native(false),

                Select::make('payment_status')
                    ->label('Status Pembayaran')
                    ->options([
                        'unpaid' => 'Belum Dibayar',
                        'paid' => 'Sudah Dibayar',
                    ])
                    ->required()
                    ->native(false),

                TextInput::make('total')
                    ->label('Total Pesanan (Rp)')
                    ->required()
                    ->numeric()
                    ->readOnly(),
            ]);
    }
}
