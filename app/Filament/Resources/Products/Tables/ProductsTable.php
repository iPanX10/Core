<?php

namespace App\Filament\Resources\Products\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Support\Enums\FontWeight;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;

class ProductsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('image_url')
                    ->label('Foto')
                    ->imageSize(56)
                    ->square(),

                TextColumn::make('name')
                    ->label('Nama Produk')
                    ->searchable()
                    ->sortable()
                    ->weight(FontWeight::SemiBold)
                    ->description(fn ($record): ?string =>
                        $record->slug ?: null
                    ),

                TextColumn::make('category.name')
                    ->label('Kategori')
                    ->searchable()
                    ->sortable()
                    ->badge()
                    ->color('info'),

                TextColumn::make('price')
                    ->label('Harga')
                    ->money('IDR', locale: 'id')
                    ->sortable()
                    ->weight(FontWeight::SemiBold),

                TextColumn::make('stock')
                    ->label('Stok')
                    ->numeric()
                    ->sortable()
                    ->badge()
                    ->color(fn ($state): string => match (true) {
                        (int) $state <= 0 => 'danger',
                        (int) $state <= 5 => 'warning',
                        default => 'success',
                    })
                    ->formatStateUsing(fn ($state): string =>
                        (int) $state <= 0
                            ? 'Habis'
                            : $state . ' unit'
                    ),

                TextColumn::make('discount_percentage')
                    ->label('Diskon')
                    ->formatStateUsing(fn ($state): string =>
                        rtrim(rtrim(number_format((float) $state, 2, '.', ''), '0'), '.')
                        . '%'
                    )
                    ->sortable()
                    ->badge()
                    ->color('primary'),

                IconColumn::make('discount_active')
                    ->label('Diskon Aktif')
                    ->boolean()
                    ->trueColor('success')
                    ->falseColor('gray'),

                TextColumn::make('created_at')
                    ->label('Dibuat')
                    ->dateTime('d M Y, H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('updated_at')
                    ->label('Terakhir Diperbarui')
                    ->dateTime('d M Y, H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('category_id')
                    ->label('Kategori')
                    ->relationship('category', 'name')
                    ->searchable()
                    ->preload(),

                SelectFilter::make('stock_status')
                    ->label('Ketersediaan Stok')
                    ->options([
                        'available' => 'Stok Tersedia',
                        'low' => 'Stok Menipis (1–5)',
                        'out' => 'Stok Habis',
                    ])
                    ->query(function ($query, array $data) {
                        return match ($data['value'] ?? null) {
                            'available' => $query->where('stock', '>', 5),
                            'low' => $query->whereBetween('stock', [1, 5]),
                            'out' => $query->where('stock', '<=', 0),
                            default => $query,
                        };
                    }),

                TernaryFilter::make('discount_active')
                    ->label('Status Diskon')
                    ->placeholder('Semua produk')
                    ->trueLabel('Diskon aktif')
                    ->falseLabel('Diskon tidak aktif'),
            ])
            ->recordActions([
                EditAction::make()
                    ->label('Edit')
                    ->icon('heroicon-m-pencil-square'),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make()
                        ->label('Hapus yang dipilih'),
                ]),
            ])
            ->defaultSort('created_at', 'desc');
    }
}