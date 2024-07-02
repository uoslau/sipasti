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
        Schema::create('mitras', function (Blueprint $table) {
            $table->id();
            $table->string('sktnp');
            $table->string('nama_mitra');
            $table->string('posisi');
            $table->string('email');
            $table->string('alamat');
            $table->date('tanggal_lahir');
            $table->string('npwp');
            $table->boolean('jenis_kelamin');
            $table->string('pekerjaan');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mitras');
    }
};