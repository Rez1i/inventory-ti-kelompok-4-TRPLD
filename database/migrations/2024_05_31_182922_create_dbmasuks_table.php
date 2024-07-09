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
        Schema::create('dbmasuks', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('barangmasuk_id')->required;
            $table->foreign('barangmasuk_id')->references('id')->on('barangmasuks');
            $table->string('kodebarang');
            $table->string('namabarang');
            $table->integer('banyakbarang');
            $table->unsignedBigInteger('satuan_id')->required;
            $table->foreign('satuan_id')->references('id')->on('satuans');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dbmasuks');
    }
};
