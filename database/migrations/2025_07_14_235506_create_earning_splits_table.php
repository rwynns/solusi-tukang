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
        Schema::create('earning_splits', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained()->onDelete('cascade');
            $table->foreignId('tukang_id')->nullable()->constrained('users')->onDelete('set null');
            $table->decimal('total_amount', 15, 2); // Total amount from order
            $table->decimal('tukang_amount', 15, 2); // 90% for tukang
            $table->decimal('admin_amount', 15, 2); // 10% for admin
            $table->decimal('tukang_percentage', 5, 2)->default(90.00); // Percentage for tukang
            $table->decimal('admin_percentage', 5, 2)->default(10.00); // Percentage for admin
            $table->enum('status', ['pending', 'distributed', 'held'])->default('pending');
            $table->timestamp('distributed_at')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->index(['tukang_id', 'status']);
            $table->index(['order_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('earning_splits');
    }
};
