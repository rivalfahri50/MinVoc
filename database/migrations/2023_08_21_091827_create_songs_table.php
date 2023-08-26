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
        Schema::create('songs', function (Blueprint $table) {
            $table->id();
            $table->string('code', 100);
            $table->string('judul');
            $table->string('genre');
            $table->string('audio');
            $table->string('image');
            $table->integer('didengar')->default(0);
            $table->integer('likes')->default(0);
            $table->foreignId('artist_id')->constrained('artists');
            $table->boolean('is_approved')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('songs');
    }
};
