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
        Schema::create('tukang_skills', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tukang_profile_id')->constrained()->onDelete('cascade');
            $table->foreignId('sub_jasa_id')->constrained('sub_jasa')->onDelete('cascade');
            $table->timestamps();

            // Mencegah duplikasi
            $table->unique(['tukang_profile_id', 'sub_jasa_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tukang_skills');
    }
};
