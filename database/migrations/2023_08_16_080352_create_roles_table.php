<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('roles', function (Blueprint $table) {
            $table->id();
            $table->string('code', 100)->unique();
            $table->enum('name', ['artis_verified', 'artis', 'pengguna', 'admin']);
            $table->timestamps();
        });

        DB::table('roles')->insert([
            ['name' => 'artis_verified', 'code' => Str::uuid()],
            ['name' => 'artis', 'code' => Str::uuid()],
            ['name' => 'pengguna', 'code' => Str::uuid()],
            ['name' => 'admin', 'code' => Str::uuid()],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('roles');
    }
};
