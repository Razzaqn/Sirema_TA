<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('industries', function (Blueprint $table) {

            $table->foreignId('master_wilayah_id')
                ->nullable()
                ->after('alamat_industri')
                ->constrained('master_wilayah')
                ->cascadeOnUpdate()
                ->nullOnDelete();

        });
    }

    public function down(): void
    {
        Schema::table('industries', function (Blueprint $table) {

            $table->dropForeign(['master_wilayah_id']);
            $table->dropColumn('master_wilayah_id');

        });
    }
};
