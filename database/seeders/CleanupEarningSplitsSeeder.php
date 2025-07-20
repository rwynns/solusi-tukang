<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\EarningSplit;
use App\Models\BalanceTransaction;
use App\Models\PlatformBalance;
use App\Models\Order;
use Illuminate\Support\Facades\DB;

class CleanupEarningSplitsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::beginTransaction();

        try {
            // Get orders yang belum completed tapi sudah ada earning split
            $ordersToCleanup = Order::whereIn('status', ['pending', 'processing'])
                ->whereHas('earningSplit')
                ->get();

            foreach ($ordersToCleanup as $order) {
                echo "Cleaning up earning splits for order #{$order->order_number} (status: {$order->status})\n";

                // Delete related balance transactions
                BalanceTransaction::where('order_id', $order->id)->delete();

                // Delete related platform balance entries
                PlatformBalance::where('reference_type', 'order')
                    ->where('reference_id', $order->id)
                    ->delete();

                // Delete earning splits
                EarningSplit::where('order_id', $order->id)->delete();
            }

            // Trigger earning split creation for completed orders that don't have splits yet
            $completedOrdersWithoutSplits = Order::where('status', 'completed')
                ->where('payment_status', 'paid')
                ->doesntHave('earningSplit')
                ->get();

            foreach ($completedOrdersWithoutSplits as $order) {
                echo "Creating earning split for completed order #{$order->order_number}\n";
                // The observer will handle this when we trigger an update
                $order->touch(); // This will trigger the observer
            }

            DB::commit();
            echo "Cleanup completed successfully!\n";
            echo "Cleaned up " . $ordersToCleanup->count() . " orders.\n";
            echo "Processed " . $completedOrdersWithoutSplits->count() . " completed orders.\n";
        } catch (\Exception $e) {
            DB::rollback();
            echo "Error during cleanup: " . $e->getMessage() . "\n";
        }
    }
}
