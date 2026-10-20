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
        Schema::create('hasil_rekomendasi', function (Blueprint $table) {
    $table->id();
    $table->foreignId('rekomendasi_id')->constrained('rekomendasi_sessions')->cascadeOnDelete();
    $table->foreignId('alternative_id')->constrained('rekomendasi_alternatives')->cascadeOnDelete();
    $table->double('qi');
    $table->integer('ranking');
    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hasil_rekomendasi');
    }
};