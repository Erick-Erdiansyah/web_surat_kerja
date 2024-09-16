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
        Schema::create('dosens', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('surat_id');
            $table->timestamps();
            // Foreign key constraint ke user
            $table->foreign('user_id')->references('id')->on('users')->noActionOnDelete()->noActionOnUpdate();
            // Foreign key constraint ke jurusan
            $table->foreign('surat_id')->references('surat_id')->on('surats')->noActionOnDelete()->noActionOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dosens');
    }
};
