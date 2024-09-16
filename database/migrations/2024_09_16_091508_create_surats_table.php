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
        Schema::create('surats', function (Blueprint $table) {
            $table->id('surat_id');
            $table->string('file');
            $table->string('judul');
            $table->string('tahun_ajaran', 9);
            $table->unsignedBigInteger('prodi_id');
            $table->timestamps();
            // Foreign key constraint ke jurusan
            $table->foreign('prodi_id')->references('id')->on('prodis')->noActionOnDelete()->noActionOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('surats');
    }
};
