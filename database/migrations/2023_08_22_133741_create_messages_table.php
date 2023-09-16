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
        Schema::create('messages', function (Blueprint $table) {
            $table->id();
            $table->string("code", 100);
            $table->foreignId("sender_id")->nullable()->constrained("artists");
            $table->foreignId("receiver_id_1")->nullable()->constrained("artists");
            $table->foreignId("receiver_id_2")->nullable()->constrained("artists");
            $table->foreignId("project_id")->nullable()->constrained("projects");
            $table->string("message");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('messages');
    }
};
