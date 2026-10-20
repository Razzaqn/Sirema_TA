<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('hasil_rekomendasi', function (Blueprint $table) {

            $table->double('wsm')->nullable();

            $table->double('wpm')->nullable();

        });
    }

    public function down(): void
    {
        Schema::table('hasil_rekomendasi', function (Blueprint $table) {

            $table->dropColumn([
                'wsm',
                'wpm'
            ]);

        });
    }
};
