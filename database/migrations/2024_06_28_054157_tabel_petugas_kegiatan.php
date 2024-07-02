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
        Schema::create('petugas_kegiatans', function (Blueprint $table) {
            $table->id();
            $table->string('sktnp');
            $table->string('nama_mitra');
            $table->foreignId('kegiatan_id');
            $table->string('bertugas_sebagai');
            $table->string('wilayah_tugas');
            $table->integer('beban');
            $table->string('satuan');
            $table->integer('honor');
            $table->date('tanggal_mulai');
            $table->date('tanggal_selesai');
            $table->string('alamat');
            $table->string('pekerjaan');
            $table->string('nomor_kontrak')->nullable();
            $table->string('nomor_bast');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('petugas_kegiatans');
    }
};
