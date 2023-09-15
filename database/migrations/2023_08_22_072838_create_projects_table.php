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
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->string('code', 100);
            $table->string('name');
            $table->text('konsep');
            $table->string('judul')->default("none");
            $table->string('images')->default("none");
            $table->string('audio')->default("none");
            $table->string('harga')->default('0');
            $table->foreignId("artist_id")->nullable()->constrained("artists");
            $table->foreignId("request_project_artis_id_1")->nullable()->constrained("artists");
            $table->foreignId("request_project_artis_id_2")->nullable()->constrained("artists");
            $table->enum('status', ['pending', 'accept', 'reject'])->nullable();
            $table->timestamp('pengajuan_project')->nullable();
            $table->integer('pembuat_project')->default(0);
            $table->integer('penerima_project')->default(0);
            $table->boolean('is_approved')->default(false);
            $table->boolean('is_reject')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};
