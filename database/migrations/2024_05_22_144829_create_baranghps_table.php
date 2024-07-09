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
        Schema::create('baranghps', function (Blueprint $table) {
            $table->id();
            $table->string('kodebarang');
            $table->string('namabarang');
            $table->unsignedBigInteger('kategoribarang_id')->required;
            $table->foreign('kategoribarang_id')->references('id')->on('kategoribarangs');
            $table->integer('tahunpengadaan')->default(date('Y'));
            $table->integer('stock');
            $table->unsignedBigInteger('satuan_id')->required;
            $table->foreign('satuan_id')->references('id')->on('satuans');
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
        Schema::dropIfExists('baranghps');
    }
};
