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
        Schema::create('jenisbarangs', function (Blueprint $table) {
            $table->id();
            $table->string('nama_jenisbarang');
            $table->unsignedBigInteger('kategoribarang_id')->required;
            $table->foreign('kategoribarang_id')->references('id')->on('kategoribarangs');
            $table->integer('jumlahbarang')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jenisbarangs');
    }
};
