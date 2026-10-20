<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('bukti_penerimaan', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->foreignId('industry_id')
                ->constrained('industries')
                ->cascadeOnDelete();

            $table->string('file_bukti');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bukti_penerimaan');
    }
};
