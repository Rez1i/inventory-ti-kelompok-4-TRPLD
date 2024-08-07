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
        Schema::create('barangmasuks', function (Blueprint $table) {
            $table->id();
            $table->string('pemasok');
            $table->unsignedBigInteger('user_id')->required;
            $table->foreign('user_id')->references('id')->on('users');
            $table->integer('stock')->default(0);
            $table->integer('tahunpengadaan');
            $table->string('laporan');
            $table->string('status')->default('-');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('barangmasuks');
    }
};
