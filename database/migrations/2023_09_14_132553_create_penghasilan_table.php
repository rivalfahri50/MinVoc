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
        Schema::create('penghasilan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('artist_id')->constrained()->cascadeOnDelete()->cascadeOnUpdate();
            $table->bigInteger('penghasilan')->default(0);
            $table->string('status');
            $table->bigInteger('penghasilanCair')->default(0);
            $table->bigInteger('Pengajuan')->default(0);
            $table->boolean('is_take')->default(false);
            $table->string('bulan');
            $table->string('status')->nullable();
            $table->timestamp('Pengajuan_tanggal')->nullable();
            $table->timestamp("terakhir_diambil")->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penghasilan');
    }
};
