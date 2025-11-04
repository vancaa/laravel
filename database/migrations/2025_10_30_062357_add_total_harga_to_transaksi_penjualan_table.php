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
        Schema::table('transaksi_penjualan', function (Blueprint $table) {
            // Kita gunakan tipe data decimal atau double untuk harga
            // decimal(10, 2) artinya 10 digit total, 2 di antaranya di belakang koma.
            $table->decimal('total_harga', 15, 2)->after('email_pembeli')->default(0.00);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('transaksi_penjualan', function (Blueprint $table) {
            $table->dropColumn('total_harga');
        });
    }
};
