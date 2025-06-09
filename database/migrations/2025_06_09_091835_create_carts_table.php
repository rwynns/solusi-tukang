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
        Schema::create('carts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('sub_jasa_id')->constrained('sub_jasa')->onDelete('cascade');
            $table->integer('quantity')->default(1);
            $table->decimal('price', 15, 2); // Simpan harga saat ditambahkan ke cart
            $table->json('additional_data')->nullable(); // Data tambahan seperti nama, gambar, satuan
            $table->timestamps();

            // Prevent duplicate items for same user and sub_jasa
            $table->unique(['user_id', 'sub_jasa_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('carts');
    }
};
