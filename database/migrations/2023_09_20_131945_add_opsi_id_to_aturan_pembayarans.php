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
        Schema::table('aturan_pembayarans', function (Blueprint $table) {
            $table->foreignId('opsi_id')->nullable()->constrained('opsi_pembayarans');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('aturan_pembayarans', function (Blueprint $table) {
            $table->dropForeign(['opsi_id']);
            $table->dropColumn('opsi_id');
        });
    }
};
