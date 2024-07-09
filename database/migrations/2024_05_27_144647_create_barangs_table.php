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
        Schema::create('barangs', function (Blueprint $table) {
            $table->id();
            $table->string('kodebarang');
            $table->string('namabarang');
            $table->unsignedBigInteger('jenisbarang_id')->required;
            $table->foreign('jenisbarang_id')->references('id')->on('jenisbarangs');
            $table->integer('stock');
            $table->unsignedBigInteger('satuan_id')->required;
            $table->foreign('satuan_id')->references('id')->on('satuans');
            $table->string('kondisi')->default('Baik');
            $table->string('sifatbarang')->default('Tidak Boleh Dipinjam');
            $table->string('status')->default('Tersedia');
            $table->integer('tahunpengadaan')->default(date('Y'));
            $table->string('foto')->default('-');
            $table->string('barcode')->default('-');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('barangs');
    }
};
