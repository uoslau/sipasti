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
        Schema::create('kegiatans', function (Blueprint $table) {
            $table->id();
            $table->string('nama_kegiatan');
            $table->string('slug')->unique();
            $table->date('tanggal_mulai');
            $table->date('tanggal_selesai');
            $table->foreignId('mata_anggaran_id');
            $table->foreignId('fungsi_id');
            $table->integer('honor_nias')->default(0);
            $table->integer('honor_nias_barat')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kegiatans');
    }
};
