<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailTransaksiPenjualan extends Model
{
    use HasFactory;

    protected $table = 'detail_transaksi_penjualan';

    public $timestamps = false;

    protected $fillable = [
        'id_transaksi_penjualan',
        'id_product',
        'jumlah_pembelian',
        'harga_saat_transaksi',
        'subtotal', 
    ];

    public function transaksi()
    {
        return $this->belongsTo(TransaksiPenjualan::class, 'id_transaksi_penjualan');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'id_product');
    }
}
