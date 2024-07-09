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
        Schema::create('prodis', function (Blueprint $table) {
            $table->id();
            $table->string('nama_prodi');
            $table->string('singkatan');
            $table->string('jenjangstudi');
            $table->string('akreditasi');
            $table->unsignedBigInteger('ketuaprodi_id')->required;
            $table->foreign('ketuaprodi_id')->references('id')->on('dosens');
            $table->string('tahunberdiri');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('prodis');
    }
};