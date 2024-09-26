<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBookmarksTable extends Migration
{
    public function up(): void
    {
        Schema::create('bookmarks', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('laporan_id');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreign('laporan_id')->references('id')->on('laporan_s_k_s')->cascadeOnDelete()->cascadeOnUpdate();
            
            $table->unique(['user_id', 'laporan_id']); // Ensures a user can only bookmark a report once
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bookmarks');
    }
}
