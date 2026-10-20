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
        Schema::create('mata_kuliah_bidangs', function (Blueprint $table) {
            $table->id();

            $table->foreignId('mata_kuliah_id')
                ->constrained('mata_kuliahs')
                ->cascadeOnDelete();

            $table->string('bidang');

            $table->timestamps();

            // Mencegah mata kuliah yang sama
            // memiliki bidang yang sama dua kali
            $table->unique([
                'mata_kuliah_id',
                'bidang'
            ]);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mata_kuliah_bidangs');
    }
};
