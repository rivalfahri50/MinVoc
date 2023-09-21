<?php

use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Str;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('code', 100);
            $table->string('avatar')->default("images/default.png");
            $table->text('deskripsi');
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password');
            $table->boolean('is_login')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });


        User::create([
            'code' => Str::uuid(),
            'avatar' => 'images/default.png',
            'deskripsi' => 'none',
            'name' => 'admin',
            'email' => 'untukprojects123@gmail.com',
            'password' => '$2y$10$eSfmaLKIg86V0xg2R1pVP.BKIusL1PRv48mxqFq5LZeImpgpul30i',
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
