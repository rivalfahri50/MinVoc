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
        Schema::create('artists', function (Blueprint $table) {
            $table->id();
            $table->string('code', 100);
            $table->foreignId('user_id')->constrained('users');
            $table->string('image')->default("none");
            $table->bigInteger('likes')->default(0);
            $table->boolean('is_verified')->default(false);
            $table->boolean('pengajuan')->default(false);
            $table->string('verification_status')->default('none');
            $table->string('penghasilan')->default('0');
            $table->timestamp('pengajuan_verified_at')->nullable();
            $table->timestamps();

            $table->index('user_id');
            $table->index('verification_status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('artists');
    }
};
