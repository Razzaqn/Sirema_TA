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
        Schema::create('konfirmasi_rekomendasi', function (Blueprint $table) {
            $table->id();

            // Mahasiswa
            $table->foreignId('user_id')
                ->constrained()
                ->cascadeOnDelete();

            // Perusahaan
            $table->foreignId('industry_id')
                ->constrained()
                ->cascadeOnDelete();

            // Mengacu ke hasil rekomendasi WASPAS
            $table->foreignId('hasil_rekomendasi_id')
                ->constrained('hasil_rekomendasi')
                ->cascadeOnDelete();

            // Informasi hasil rekomendasi
            $table->integer('ranking');
            $table->decimal('nilai_waspas', 8, 4);

            // Status proses
            $table->enum('status', [
                'direkomendasikan',
                'hold_aktif',
                'diterima',
                'hold_berakhir',
                'dibatalkan'
            ])->default('direkomendasikan');

            // Informasi hold
            $table->timestamp('hold_started_at')->nullable();
            $table->timestamp('hold_expired_at')->nullable();
            $table->timestamp('activated_at')->nullable();

            $table->timestamps();

            // Satu mahasiswa hanya boleh memiliki satu data konfirmasi
            // untuk satu perusahaan pada satu hasil rekomendasi.
            $table->unique([
                'user_id',
                'industry_id',
                'hasil_rekomendasi_id'
            ], 'konfirmasi_unique');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('konfirmasi_rekomendasi');
    }
};
