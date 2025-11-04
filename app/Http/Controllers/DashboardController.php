<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Supplier;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // Total ringkasan
        $totalProducts = Product::count();
        $totalSuppliers = Supplier::count();
        $totalTransactions = DB::table('transaksi_penjualan')->count();
     $validTransactionIds = DB::table('transaksi_penjualan')->pluck('id');
     $totalSoldProducts = DB::table('detail_transaksi_penjualan')
    ->whereIn('id_transaksi_penjualan', $validTransactionIds)
    ->sum('jumlah_pembelian');

        // === Grafik Penjualan Bulanan ===
        $salesPerMonth = DB::table('transaksi_penjualan')
            ->select(DB::raw('MONTH(tanggal_transaksi) as month'), DB::raw('COUNT(*) as total'))
            ->groupBy('month')
            ->orderBy('month')
            ->pluck('total', 'month')
            ->toArray();

        // Format bulan biar tampil rapi (Jan–Dec)
        $months = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];
        $salesData = [];
        for ($i = 1; $i <= 12; $i++) {
            $salesData[] = $salesPerMonth[$i] ?? 0;
        }

       $productByCategory = DB::table('products')
    ->join('category_product', 'products.product_category_id', '=', 'category_product.id')
    ->select('category_product.product_category_name as category', DB::raw('COUNT(products.id) as total'))
    ->groupBy('category_product.product_category_name')
    ->pluck('total', 'category')
    ->toArray();

        return view('dashboard.dashboard', compact(
            'totalProducts',
            'totalSuppliers',
            'totalTransactions',
            'totalSoldProducts',
            'months',
            'salesData',
            'productByCategory'
        ));
    }
}
