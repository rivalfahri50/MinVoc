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
        Schema::create('notifs', function (Blueprint $table) {
            $table->id();
            $table->string('code', 100);
            $table->string('title');
            $table->text('message')->nullable();
            $table->foreignId('user_id')->nullable()->constrained('users');
            $table->foreignId('song_id')->nullable()->constrained('songs')->onDelete('cascade');;
            $table->boolean('is_reject')->default(false);
            $table->enum('type', ['pencairan', 'lagu', 'verifikasi'])->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notifs');
    }
};
