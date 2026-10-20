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
        Schema::create('rekomendasi_scores', function (Blueprint $table) {
    $table->id();
    $table->foreignId('rekomendasi_id')->constrained('rekomendasi_sessions')->cascadeOnDelete();
    $table->foreignId('industry_id')->constrained('industries')->cascadeOnDelete();

    $table->float('c2');
    $table->float('c3');
    $table->float('c4');
    $table->float('c5');

    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rekomendasi_scores');
    }
};
