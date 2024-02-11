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
        Schema::create('tarif_lembur_fixes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('gol');
            $table->integer('tarif');
            $table->integer('uang_makan');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tarif_lembur_fixes');
    }
};
