<?php

namespace App\Http\Controllers;

use App\Models\TransaksiPenjualan;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail; 

class TransaksiPenjualanController extends Controller
{
    public function index()
    {
        // Asumsi logic index dari code yang Anda berikan sebelumnya
        $transaksis = TransaksiPenjualan::with('details.product')->latest()->paginate(4);
        
        return view('transaksi.index', compact('transaksis'));
    }

    public function create()
    {

        $products = Product::orderBy('title')->get();
        return view('transaksi.create', compact('products'));
    }

    public function show(TransaksiPenjualan $transaksi)
    {
        // Menambahkan method ini
        $transaksi->load('details.product');
        return view('transaksi.show', compact('transaksi'));
    }
    
    public function edit(TransaksiPenjualan $transaksi)
    {
        // Menambahkan method ini
        $products = Product::orderBy('title')->get();
        $transaksi->load('details');
        return view('transaksi.edit', compact('transaksi', 'products'));
    }

    /**
     * Handle incoming product purchases and send email.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_kasir' => 'required|string|max:50',
            'email_pembeli' => 'nullable|email', 
            'products' => 'required|array|min:1',
            'products.*.id' => 'required|exists:products,id',
            'products.*.jumlah' => 'required|integer|min:1',
        ]);

        $grandTotal = 0;
        $itemsToProcess = [];

        foreach ($request->products as $productData) {
            $product = Product::find($productData['id']);

            if ($product->stock < $productData['jumlah']) {
                return redirect()->back()
                    ->with('error', 'Stok untuk produk "' . $product->title . '" tidak mencukupi. Sisa stok: ' . $product->stock)
                    ->withInput();
            }

            $subtotal = $product->price * $productData['jumlah'];
            $grandTotal += $subtotal;

            $itemsToProcess[] = [
                'product' => $product,
                'jumlah' => $productData['jumlah'],
                'harga_saat_transaksi' => $product->price, 
                'subtotal' => $subtotal,
            ];
        }

        try {
            DB::transaction(function () use ($request, $grandTotal, $itemsToProcess, &$transaksi) {
                
                $transaksi = TransaksiPenjualan::create([
                    'nama_kasir' => $request->nama_kasir,
                    'email_pembeli' => $request->email_pembeli,
                    'total_harga' => $grandTotal, 
                ]);

                foreach ($itemsToProcess as $item) {
                    $transaksi->details()->create([
                        'id_product' => $item['product']->id,
                        'jumlah_pembelian' => $item['jumlah'],
                        'harga_saat_transaksi' => $item['harga_saat_transaksi'], 
                        'subtotal' => $item['subtotal'], 
                    ]);
                    $item['product']->decrement('stock', $item['jumlah']);
                }

                if ($transaksi->email_pembeli) {
                    $this->sendEmail($transaksi->email_pembeli, $transaksi->id);
                }
            });

            return redirect()->route('transaksi.index')->with('success', 'Transaksi berhasil dibuat dan email telah ' . ($request->email_pembeli ? 'dikirim.' : 'diabaikan karena email kosong.'));

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal membuat transaksi: ' . $e->getMessage())->withInput();
        }
    }


    /**
     * Update transaction data (optional send email)
     */
    public function update(Request $request, TransaksiPenjualan $transaksi)
    { 
        $request->validate([
            'nama_kasir' => 'required|string|max:50',
            'email_pembeli' => 'nullable|email',
        ]);

        $transaksi->update($request->only(['nama_kasir', 'email_pembeli']));

        if ($transaksi->email_pembeli) {
            $this->sendEmail($transaksi->email_pembeli, $transaksi->id);
        }

        return redirect()->route('transaksi.index')->with('success', 'Data transaksi berhasil diupdate dan email telah ' . ($transaksi->email_pembeli ? 'dikirim ulang.' : 'diabaikan karena email kosong.'));
    }
    
    public function destroy(TransaksiPenjualan $transaksi)
    {
        DB::transaction(function() use ($transaksi) {
            foreach($transaksi->details as $detail) {
                Product::find($detail->id_product)->increment('stock', $detail->jumlah_pembelian);
            }
            $transaksi->delete();
        });
        
        return redirect()->route('transaksi.index')->with('success', 'Transaksi berhasil dihapus.');
    }


    public function sendEmail($to, $id)
    {
        $transaksi = TransaksiPenjualan::with('details.product') 
            ->find($id); 
            
        if (!$transaksi) {
            return response()->json(['message' => 'Transaksi not found!'], 404);
        }

        $grandTotal = $transaksi->total_harga ?? $transaksi->details->sum('subtotal');

        $emailData = [
            'transaksi' => $transaksi,
            'details' => $transaksi->details,
            'total_harga' => $grandTotal
        ];

        Mail::send('emails.transaksi_detail', $emailData, function ($message) use ($to, $transaksi, $grandTotal) {
            
            $subject = "Detail Transaksi: #" . $transaksi->id . " dengan Total Tagihan RP. " . number_format($grandTotal, 2, ',', '.') ;

            $message->to($to)
                    ->subject($subject);
        }); 

        return response()->json(['message' => 'Email sent successfully!']);
    }
}
