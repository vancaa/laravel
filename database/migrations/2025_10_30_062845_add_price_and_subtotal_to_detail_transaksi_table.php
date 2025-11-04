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
        Schema::table('detail_transaksi_penjualan', function (Blueprint $table) {
            // Kolom harga produk saat transaksi terjadi
            $table->decimal('harga_saat_transaksi', 15, 2)->after('jumlah_pembelian')->default(0.00); 
            
            // Kolom subtotal untuk baris ini (harga * jumlah)
            $table->decimal('subtotal', 15, 2)->after('harga_saat_transaksi')->default(0.00);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('detail_transaksi_penjualan', function (Blueprint $table) {
            $table->dropColumn(['harga_saat_transaksi', 'subtotal']);
        });
    }
};
