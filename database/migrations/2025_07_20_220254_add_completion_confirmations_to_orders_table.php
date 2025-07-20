<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->boolean('customer_confirmed')->default(false)->after('notes');
            $table->boolean('tukang_confirmed')->default(false)->after('customer_confirmed');
            $table->timestamp('customer_confirmed_at')->nullable()->after('tukang_confirmed');
            $table->timestamp('tukang_confirmed_at')->nullable()->after('customer_confirmed_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn(['customer_confirmed', 'tukang_confirmed', 'customer_confirmed_at', 'tukang_confirmed_at']);
        });
    }
};
