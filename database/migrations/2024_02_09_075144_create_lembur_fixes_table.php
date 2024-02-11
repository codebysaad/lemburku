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
        Schema::create('lembur_fixes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nama');
            $table->string('gol');
            $table->date('tgl_lembur');
            $table->time('mulai');
            $table->time('akhir');
            $table->time('pengajuan_awal');
            $table->time('pengajuan_akhir');
            $table->time('durasi_pengajuan');
            $table->integer('harga');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lembur_fixes');
    }
};
