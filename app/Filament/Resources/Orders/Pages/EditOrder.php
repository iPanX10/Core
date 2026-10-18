<?php

namespace App\Filament\Resources\Orders\Pages;

use App\Filament\Resources\Orders\OrderResource;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class EditOrder extends EditRecord
{
    protected static string $resource = OrderResource::class;

    protected function getHeaderActions(): array
    {
        return [];
    }

    protected function handleRecordUpdate(
        Model $record,
        array $data
    ): Model {
        return DB::transaction(function () use ($record, $data) {
            $order = Order::whereKey($record->getKey())
                ->lockForUpdate()
                ->firstOrFail();

            $oldStatus = $order->status;
            $newStatus = $data['status'] ?? $oldStatus;

            $oldPaymentStatus = $order->payment_status;
            $newPaymentStatus = $data['payment_status']
                ?? $oldPaymentStatus;

            // Status pesanan mengikuti metode penerimaan.
            $allowedTransitions = $order->fulfillment_method === 'pickup'
                ? [
                    'pending' => ['processing', 'cancelled'],
                    'processing' => ['completed', 'cancelled'],
                    'shipped' => [],
                    'completed' => [],
                    'cancelled' => [],
                ]
                : [
                    'pending' => ['processing', 'cancelled'],
                    'processing' => ['shipped', 'cancelled'],
                    'shipped' => ['completed'],
                    'completed' => [],
                    'cancelled' => [],
                ];

            $validStatuses = [
                'pending',
                'processing',
                'shipped',
                'completed',
                'cancelled',
            ];

            if (! in_array($newStatus, $validStatuses, true)) {
                Notification::make()
                    ->title('Status pesanan tidak valid')
                    ->body('Pilih status pesanan yang tersedia.')
                    ->danger()
                    ->persistent()
                    ->send();

                throw ValidationException::withMessages([
                    'status' => 'Status pesanan tidak valid.',
                ]);
            }

            // Validasi transisi status.
            if (
                $newStatus !== $oldStatus
                && ! in_array(
                    $newStatus,
                    $allowedTransitions[$oldStatus] ?? [],
                    true
                )
            ) {
                Notification::make()
                    ->title('Perubahan pesanan ditolak')
                    ->body(
                        'Pesanan yang sudah dibatalkan atau selesai tidak dapat diaktifkan kembali.'
                    )
                    ->danger()
                    ->persistent()
                    ->send();

                throw ValidationException::withMessages([
                    'status' => 'Transisi status pesanan tidak diizinkan.',
                ]);
            }

            // Validasi nilai status pembayaran.
            if (! in_array($newPaymentStatus, ['unpaid', 'paid'], true)) {
                Notification::make()
                    ->title('Status pembayaran tidak valid')
                    ->body('Pilih status pembayaran yang tersedia.')
                    ->danger()
                    ->persistent()
                    ->send();

                throw ValidationException::withMessages([
                    'payment_status' => 'Status pembayaran tidak valid.',
                ]);
            }

            // Pembayaran yang sudah lunas tidak dapat diturunkan.
            if (
                $oldPaymentStatus === 'paid'
                && $newPaymentStatus !== 'paid'
            ) {
                Notification::make()
                    ->title('Perubahan pembayaran ditolak')
                    ->body(
                        'Pembayaran yang sudah diverifikasi tidak dapat diubah menjadi belum dibayar.'
                    )
                    ->danger()
                    ->persistent()
                    ->send();

                throw ValidationException::withMessages([
                    'payment_status' => 'Status pembayaran tidak dapat diturunkan.',
                ]);
            }

            // Pesanan yang dibatalkan tidak boleh ditandai lunas.
            if (
                $newStatus === 'cancelled'
                && $newPaymentStatus === 'paid'
            ) {
                Notification::make()
                    ->title('Pembatalan ditolak')
                    ->body(
                        'Pesanan yang dibatalkan tidak dapat ditandai sudah dibayar.'
                    )
                    ->danger()
                    ->persistent()
                    ->send();

                throw ValidationException::withMessages([
                    'payment_status' => 'Pesanan yang dibatalkan tidak dapat ditandai sudah dibayar.',
                ]);
            }

            // Pesanan yang sudah dibayar memerlukan alur refund.
            if (
                $newStatus === 'cancelled'
                && $oldPaymentStatus === 'paid'
            ) {
                Notification::make()
                    ->title('Pembatalan ditolak')
                    ->body(
                        'Pesanan sudah dibayar. Selesaikan proses refund terlebih dahulu.'
                    )
                    ->danger()
                    ->persistent()
                    ->send();

                throw ValidationException::withMessages([
                    'status' => 'Pesanan yang sudah dibayar memerlukan proses refund.',
                ]);
            }

            // Kembalikan stok hanya saat pembatalan pertama.
            if (
                $newStatus === 'cancelled'
                && $oldStatus !== 'cancelled'
                && $order->stock_returned_at === null
            ) {
                $items = OrderItem::where('order_id', $order->id)
                    ->whereNotNull('product_id')
                    ->orderBy('product_id')
                    ->lockForUpdate()
                    ->get();

                foreach ($items as $item) {
                    $product = Product::whereKey($item->product_id)
                        ->lockForUpdate()
                        ->first();

                    // Produk yang sudah dihapus dilewati.
                    if ($product) {
                        $product->increment('stock', $item->quantity);
                    }
                }

                $order->stock_returned_at = now();
            }

            $order->status = $newStatus;
            $order->payment_status = $newPaymentStatus;
            $order->save();

            return $order;
        });
    }
}