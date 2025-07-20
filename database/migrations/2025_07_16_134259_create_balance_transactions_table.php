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
        Schema::create('balance_transactions', function (Blueprint $table) {
            $table->id();
            $table->string('transaction_id')->unique();
            $table->enum('type', [
                'customer_payment',
                'withdrawal_request',
                'withdrawal_completed',
                'withdrawal_cancelled',
                'admin_fee',
                'refund',
                'adjustment'
            ]);
            $table->foreignId('order_id')->nullable()->constrained()->onDelete('set null');
            $table->foreignId('withdrawal_request_id')->nullable()->constrained('withdrawal_requests')->onDelete('set null');
            $table->foreignId('tukang_id')->nullable()->constrained('users')->onDelete('set null');
            $table->decimal('amount', 15, 2);
            $table->decimal('balance_before', 15, 2)->nullable();
            $table->decimal('balance_after', 15, 2)->nullable();
            $table->text('description');
            $table->json('metadata')->nullable();
            $table->timestamps();

            $table->index(['type', 'tukang_id']);
            $table->index('transaction_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('balance_transactions');
    }
};
