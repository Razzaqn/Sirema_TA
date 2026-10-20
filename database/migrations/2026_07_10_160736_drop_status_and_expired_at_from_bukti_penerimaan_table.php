<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('bukti_penerimaan', function (Blueprint $table) {

            $table->dropColumn([
                'status',
                'expired_at'
            ]);

        });
    }

    public function down(): void
    {
        Schema::table('bukti_penerimaan', function (Blueprint $table) {

            $table->string('status')->default('aktif');

            $table->timestamp('expired_at')->nullable();

        });
    }
};
