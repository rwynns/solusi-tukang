<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Order;

class UpdateExistingOrdersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Update all completed orders to have both confirmations
        Order::where('status', 'completed')
            ->update([
                'customer_confirmed' => true,
                'tukang_confirmed' => true,
                'customer_confirmed_at' => now(),
                'tukang_confirmed_at' => now()
            ]);

        echo "Updated existing completed orders with confirmation data.\n";
    }
}
