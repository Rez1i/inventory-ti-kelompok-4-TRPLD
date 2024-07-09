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
        Schema::create('barangkeluars', function (Blueprint $table) {
            $table->id();
            $table->string('penerima');
            $table->unsignedBigInteger('barangkeluar_id')->required;
            $table->foreign('barangkeluar_id')->references('id')->on('baranghps');
            $table->unsignedBigInteger('user_id')->required;
            $table->foreign('user_id')->references('id')->on('users');
            $table->integer('banyakbarang');
            $table->unsignedBigInteger('satuan_id')->required;
            $table->foreign('satuan_id')->references('id')->on('satuans');
            $table->text('tujuan');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('barangkeluars');
    }
};
