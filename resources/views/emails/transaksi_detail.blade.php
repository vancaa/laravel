<!DOCTYPE html>
<html>
<head>
    <title>Detail Transaksi</title>
    <style>
        body { font-family: sans-serif; }
        .container { width: 90%; margin: 0 auto; border: 1px solid #eee; padding: 20px; }
        table { width: 100%; border-collapse: collapse; margin-top: 15px; }
        th, td { border: 1px solid #ddd; padding: 10px; text-align: left; }
        .total { background-color: #f9f9f9; font-weight: bold; }
        .header { background-color: #3f51b5; color: white; padding: 15px; text-align: center; }
        /* Pastikan angka ditampilkan di kanan */
        .angka-kanan { text-align: right; } 
        .angka-tengah { text-align: center; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h2>Konfirmasi Transaksi Penjualan</h2>
        </div>

        <p>Halo, <strong>{{ $transaksi->nama_kasir }}</strong> telah menyelesaikan transaksi untuk Anda.</p>
        
        {{-- Menggunakan Carbon::parse untuk memformat tanggal dengan aman --}}
        <p>Berikut adalah detail transaksi dengan ID <strong>#{{ $transaksi->id }}</strong> pada tanggal {{ \Carbon\Carbon::parse($transaksi->created_at)->format('d M Y H:i:s') }}:</p>

        <table>
            <thead>
                <tr>
                    <th>Produk</th>
                    <th class="angka-kanan">Harga Satuan</th>
                    <th class="angka-tengah">Jumlah</th>
                    <th class="angka-kanan">Subtotal</th>
                </tr>
            </thead>
            <tbody>
                {{-- Loop melalui detail transaksi yang dimuat dari Controller --}}
                @foreach($details as $detail)
                <tr>
                    <td>{{ $detail->product->title }}</td> 
                    
                    {{-- Harga Satuan: Mengambil dari kolom yang tersimpan saat transaksi --}}
                    <td class="angka-kanan">Rp. {{ number_format($detail->harga_saat_transaksi, 0, ',', '.') }}</td>
                    
                    {{-- Jumlah: Mengambil dari kolom jumlah_pembelian --}}
                    <td class="angka-tengah">{{ $detail->jumlah_pembelian }}</td>
                    
                    {{-- Subtotal: Mengambil dari kolom subtotal yang disimpan --}}
                    <td class="angka-kanan">Rp. {{ number_format($detail->subtotal, 0, ',', '.') }}</td>
                </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr class="total">
                    <td colspan="3" class="angka-kanan">TOTAL TAGIHAN:</td>
                    {{-- Total Tagihan: Mengambil variabel $total_harga yang dihitung Controller --}}
                    <td class="angka-kanan"><strong>Rp. {{ number_format($total_harga, 0, ',', '.') }}</strong></td>
                </tr>
            </tfoot>
        </table>

        <p>Terima kasih atas transaksi Anda. Mohon simpan email ini sebagai bukti pembayaran.</p>
        <p>Salam hangat,<br>Sistem Informasi | Universitas Kristen Krida Wacana</p>
    </div>
</body>
</html>
