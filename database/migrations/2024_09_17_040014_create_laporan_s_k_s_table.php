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
        Schema::create('laporan_s_k_s', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('jurusan_id');
            $table->unsignedBigInteger('kategori_id');
            $table->unsignedBigInteger('sub_kategori_id');
            $table->string('nomor_surat');
            $table->string('tanggal_surat');
            $table->string('judul');
            $table->text('deskripsi');
            $table->string('tahun_ajaran', 9);
            $table->string('file');
            $table->timestamps();

            $table->foreign('jurusan_id')->references(columns: 'id')->on('jurusan ')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreign('kategori_id')->references('id')->on('kategoris')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreign('sub_kategori_id')->references('id')->on('sub_kategoris')->cascadeOnDelete()->cascadeOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('laporan_s_k_s');
    }
};
