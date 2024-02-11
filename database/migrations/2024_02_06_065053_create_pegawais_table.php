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
        Schema::create('pegawais', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nama');
            $table->bigInteger('nip')->unique();
            $table->unsignedBigInteger('pangkat_id');
            $table->string('jabatan')->nullable();
            $table->timestamps();
            $table->foreign('pangkat_id')
                ->references('id')->on('pangkat_gols')->onDelete('restrict')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pegawais');
    }
};
