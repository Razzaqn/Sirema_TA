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
    Schema::create('master_wilayah', function (Blueprint $table) {

        $table->id();

        $table->string('nama_wilayah');

        $table->string('provinsi');

        $table->decimal('jarak_km', 8, 2);

        $table->decimal('estimasi_biaya_hidup', 12, 2);

        $table->timestamps();

    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('master_wilayahs');
    }
};