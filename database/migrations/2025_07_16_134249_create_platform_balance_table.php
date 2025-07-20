<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('platform_balance', function (Blueprint $table) {
            $table->id();
            $table->decimal('total_balance', 15, 2)->default(0);
            $table->decimal('available_balance', 15, 2)->default(0);
            $table->decimal('pending_withdrawals', 15, 2)->default(0);
            $table->decimal('admin_earnings', 15, 2)->default(0);
            $table->timestamps();
        });

        // Insert initial record
        DB::table('platform_balance')->insert([
            'total_balance' => 0,
            'available_balance' => 0,
            'pending_withdrawals' => 0,
            'admin_earnings' => 0,
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('platform_balance');
    }
};
