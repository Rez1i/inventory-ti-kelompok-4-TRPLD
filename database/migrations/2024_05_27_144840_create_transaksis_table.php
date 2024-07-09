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
        Schema::create('transaksis', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('barang_id')->required;
            $table->foreign('barang_id')->references('id')->on('barangs');
            $table->string('peminjam');
            $table->unsignedBigInteger('user_id')->required;
            $table->foreign('user_id')->references('id')->on('users');
            $table->datetime('waktupinjam')->nullable();
            $table->datetime('bataswaktu')->nullable();
            $table->datetime('waktudikembalikan')->nullable();
            $table->string('status')->default('-');
            $table->text('sarankomentar');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaksis');
    }
};
