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
        Schema::create('penugasans', function (Blueprint $table) {
            $table->id();
            $table->string('sktnp');
            $table->string('nama_mitra');
            $table->string('slug')->unique();
            $table->string('wilayah_tugas');
            $table->string('nama_kegiatan');
            $table->foreignId('kegiatan_id');
            $table->string('bertugas_sebagai');
            $table->string('beban');
            $table->string('honor');
            $table->string('fungsi');
            $table->date('tanggal_mulai');
            $table->date('tanggal_selesai');
            $table->string('alamat');
            $table->string('pekerjaan');
            $table->string('mata_anggaran');
            $table->string('nomor_bast');
            $table->integer('generate_number')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penugasans');
    }
};
