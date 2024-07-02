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
        Schema::create('nomor_kontrak', function (Blueprint $table) {
            $table->id();
            $table->string('sktnp');
            $table->integer('year');
            $table->integer('month');
            $table->integer('last_bast_number')->default(0);
            $table->integer('last_contract_number')->default(0);
            $table->integer('last_global_contract_number')->default(0);
            $table->timestamps();

            $table->unique(['sktnp', 'year', 'month']); // ensure unique combination of sktnp, year, and month
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('nomor_kontrak');
    }
};
