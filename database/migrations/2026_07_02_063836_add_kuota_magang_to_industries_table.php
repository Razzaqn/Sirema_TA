<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('industries', function (Blueprint $table) {

            $table->unsignedInteger('kuota_magang')
                ->default(1)
                ->after('kualifikasi_skill');

        });
    }

    public function down(): void
    {
        Schema::table('industries', function (Blueprint $table) {

            $table->dropColumn('kuota_magang');

        });
    }
};
