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
        Schema::create('lemburs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('pegawai_id');
            $table->date('tgl_lembur');
            $table->time('mulai');
            $table->time('akhir');
            $table->time('pengajuan_awal');
            $table->time('pengajuan_akhir');
            $table->time('durasi_pengajuan');
            $table->integer('harga');
            $table->timestamps();
            $table->foreign('pegawai_id')
                ->references('id')->on('pegawais')->onDelete('restrict')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lemburs');
    }
};
