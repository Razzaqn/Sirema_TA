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
        Schema::create('nilais', function (Blueprint $table) {
    $table->id();

    $table->foreignId('user_id')->constrained()->onDelete('cascade'); // 🔥 WAJIB
    $table->foreignId('mata_kuliah_id')->constrained()->onDelete('cascade');

    $table->string('nilai_huruf'); // A, AB, B
    $table->float('nilai_mutu');   // 4.0, 3.5, dst
    $table->integer('semester');   // 1,2,3

    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('nilais');
    }
};
