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
        Schema::create('tarif_lemburs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('gol_id');
            $table->integer('tarif');
            $table->integer('uang_makan');
            $table->timestamps();
            $table->foreign('gol_id')
                ->references('id')->on('pangkat_gols')->onDelete('restrict')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tarif_lemburs');
    }
};
