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
        Schema::create('dmutasibarangs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('mutasi_id')->required;
            $table->foreign('mutasi_id')->references('id')->on('mutasibarangs');
            $table->string('kodebarang');
            $table->string('namabarang');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dmutasibarangs');
    }
};
