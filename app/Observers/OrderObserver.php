<?php

namespace App\Observers;

use App\Models\Order;
use App\Models\EarningSplit;
use App\Models\BalanceTransaction;
use App\Models\PlatformBalance;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class OrderObserver
{
    /**
     * Handle the Order "created" event.
     */
    public function created(Order $order): void
    {
        //
    }

    /**
     * Handle the Order "updated" event.
     */
    public function updated(Order $order): void
    {
        // Log semua perubahan untuk debugging
        Log::info("Order updated", [
            'order_id' => $order->id,
            'status' => $order->status,
            'payment_status' => $order->payment_status,
            'dirty_fields' => $order->getDirty()
        ]);

        // Update status pesanan menjadi 'processing' ketika payment sudah 'paid'
        if ($order->isDirty('payment_status') && $order->payment_status === 'paid') {
            Log::info("Payment verified for order {$order->id}");

            if ($order->status === 'pending') {
                $order->update(['status' => 'processing']);
                Log::info("Order status updated to 'processing' for order {$order->id}");
            }
        }

        // Proses pembagian pendapatan ketika status berubah menjadi 'completed'
        if ($order->isDirty('status') && $order->status === 'completed') {
            Log::info("Processing payment distribution for completed order {$order->id}");
            $this->processPaymentDistribution($order);
        }
    }
    /**
     * Handle the Order "deleted" event.
     */
    public function deleted(Order $order): void
    {
        //
    }

    /**
     * Handle the Order "restored" event.
     */
    public function restored(Order $order): void
    {
        //
    }

    /**
     * Handle the Order "force deleted" event.
     */
    public function forceDeleted(Order $order): void
    {
        //
    }

    /**
     * Process payment distribution when order is completed
     */
    private function processPaymentDistribution(Order $order)
    {
        try {
            DB::beginTransaction();

            // Pastikan payment sudah lunas sebelum membagi hasil
            if ($order->payment_status !== 'paid') {
                Log::warning("Cannot distribute payment for order {$order->id}: payment not yet verified");
                DB::rollback();
                return;
            }

            // Cek apakah earning split sudah pernah dibuat untuk order ini
            $existingSplit = EarningSplit::where('order_id', $order->id)->exists();
            if ($existingSplit) {
                Log::info("Earning split already exists for order {$order->id}");
                DB::rollback();
                return;
            }

            // Group order items by tukang
            $tukangGroups = $this->groupItemsByTukang($order);

            if (empty($tukangGroups)) {
                Log::error("No tukang found for order {$order->id}");
                DB::rollback();
                return;
            }

            $totalAdminAmount = 0;

            // Create earning split for each tukang
            foreach ($tukangGroups as $tukangId => $items) {
                $tukang = \App\Models\User::find($tukangId);
                if (!$tukang) {
                    Log::error("Tukang with ID {$tukangId} not found");
                    continue;
                }

                // Calculate total amount for this tukang's items
                $tukangTotalAmount = collect($items)->sum('subtotal');

                // Calculate splits - menggunakan persentase yang sama dengan EarningSplit model
                $tukangPercentage = 90; // 90% untuk tukang
                $adminPercentage = 10;  // 10% untuk admin

                $tukangAmount = ($tukangTotalAmount * $tukangPercentage) / 100;
                $adminAmount = ($tukangTotalAmount * $adminPercentage) / 100;

                $totalAdminAmount += $adminAmount;

                // Create earning split record for this tukang
                $earningSplit = EarningSplit::create([
                    'order_id' => $order->id,
                    'tukang_id' => $tukang->id,
                    'total_amount' => $tukangTotalAmount,
                    'tukang_amount' => $tukangAmount,
                    'admin_amount' => $adminAmount,
                    'tukang_percentage' => $tukangPercentage,
                    'admin_percentage' => $adminPercentage,
                    'status' => 'distributed',
                    'distributed_at' => now(),
                    'notes' => "Otomatis dibuat saat pesanan selesai untuk order #{$order->order_number} - Tukang: {$tukang->name}"
                ]);

                // Create balance transaction for this tukang
                BalanceTransaction::create([
                    'transaction_id' => 'EARN-' . $order->order_number . '-' . $tukang->id,
                    'type' => 'customer_payment',
                    'order_id' => $order->id,
                    'tukang_id' => $tukang->id,
                    'amount' => $tukangAmount,
                    'description' => "Pendapatan dari order selesai #{$order->order_number} - {$tukang->name}",
                    'metadata' => [
                        'order_number' => $order->order_number,
                        'customer_name' => $order->customer_name,
                        'earning_split_id' => $earningSplit->id,
                        'tukang_name' => $tukang->name,
                        'completed_at' => now()->toISOString()
                    ]
                ]);

                Log::info("Created earning split for tukang {$tukang->id} ({$tukang->name}): Rp{$tukangAmount}");
            }

            // Update platform balance for total admin amount
            $this->updatePlatformBalance($totalAdminAmount, $order);

            DB::commit();

            Log::info("Payment distribution completed for completed order {$order->id}. Total admin amount: Rp{$totalAdminAmount}");
        } catch (\Exception $e) {
            DB::rollback();
            Log::error("Failed to process payment distribution for completed order {$order->id}: " . $e->getMessage());
        }
    }

    /**
     * Group order items by tukang
     */
    private function groupItemsByTukang(Order $order)
    {
        $items = $order->items()->with('tukangProfile.user')->get();
        $grouped = [];

        foreach ($items as $item) {
            if ($item->tukangProfile && $item->tukangProfile->user) {
                $tukangId = $item->tukangProfile->user->id;
                if (!isset($grouped[$tukangId])) {
                    $grouped[$tukangId] = [];
                }
                $grouped[$tukangId][] = $item;
            } else {
                Log::warning("Order item {$item->id} has no associated tukang");
            }
        }

        return $grouped;
    }

    /**
     * Update platform balance
     */
    private function updatePlatformBalance($adminAmount, Order $order)
    {
        $currentBalance = PlatformBalance::getCurrentBalance();

        PlatformBalance::create([
            'transaction_type' => 'earning',
            'amount' => $adminAmount,
            'balance_before' => $currentBalance,
            'balance_after' => $currentBalance + $adminAmount,
            'description' => "Bagian admin dari order selesai #{$order->order_number}",
            'reference_type' => 'order',
            'reference_id' => $order->id,
            'metadata' => [
                'order_number' => $order->order_number,
                'customer_name' => $order->customer_name,
                'admin_percentage' => 10,
                'completed_at' => now()->toISOString()
            ]
        ]);
    }
}
