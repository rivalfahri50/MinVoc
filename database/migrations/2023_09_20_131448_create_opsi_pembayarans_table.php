<?php

use App\Models\opsiPembayaran;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('opsi_pembayarans', function (Blueprint $table) {
            $table->id();
            $table->string('code');
            $table->enum('tipe', ['mendengarkan lagu', 'upload lagu', 'kolaborasi']);
            $table->timestamps();
        });

        opsiPembayaran::create([
            'code' => Str::uuid(),
            'tipe' => 'mendengarkan lagu'
        ]);

        opsiPembayaran::create([
            'code' => Str::uuid(),
            'tipe' => 'upload lagu'
        ]);

        opsiPembayaran::create([
            'code' => Str::uuid(),
            'tipe' => 'kolaborasi'
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('opsi_pembayarans');
    }
};
