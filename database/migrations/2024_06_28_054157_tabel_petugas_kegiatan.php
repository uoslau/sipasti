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
            $table->string('slug');
            $table->foreignId('kegiatan_id');
            $table->string('bertugas_sebagai');
            $table->string('wilayah_tugas');
            $table->string('beban');
            $table->integer('honor');
            $table->string('alamat');
            $table->string('pekerjaan');
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
        Schema::dropIfExists('petugas_kegiatans');
    }
};
