<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('rekomendasi_sessions', function (Blueprint $table) {

            $table->longText('bobot_ahp')->nullable();

            $table->double('cr')->nullable();

        });
    }

    public function down(): void
    {
        Schema::table('rekomendasi_sessions', function (Blueprint $table) {

            $table->dropColumn([
                'bobot_ahp',
                'cr'
            ]);

        });
    }
};
