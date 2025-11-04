@extends('layouts.app')
@section('judulHalaman', 'Buat Transaksi Baru')

@section('content')
<div class="halaman-penuh">
    <div class="header-tambah">
        <div>
            <h1>Buat Transaksi Baru</h1>
            <p>Isi detail transaksi dan tambahkan produk yang dibeli.</p>
        </div>
    </div>

    <div class="kartu-form">
        <form action="{{ route('transaksi.store') }}" method="POST">
            @csrf

            {{-- Pesan error dari session --}}
            @if (session('error'))
                <div class="alert alert-danger" style="margin-bottom: 1rem; color: #dc3545;">
                    {{ session('error') }}
                </div>
            @endif

            {{-- Informasi Kasir & Pembeli --}}
            <div class="formulir-grid">
                <div class="grup-formulir">
                    <label for="nama_kasir">Nama Kasir</label>
                    <input 
                        type="text" 
                        id="nama_kasir" 
                        name="nama_kasir" 
                        value="{{ old('nama_kasir') }}" 
                        required>
                    @error('nama_kasir')<div class="pesan-error">{{ $message }}</div>@enderror
                </div>

                <div class="grup-formulir">
                    <label for="email_pembeli">Email Pembeli </label>
                    <input 
                        type="email" 
                        id="email_pembeli" 
                        name="email_pembeli" 
                        value="{{ old('email_pembeli') }}">
                    @error('email_pembeli')<div class="pesan-error">{{ $message }}</div>@enderror
                </div>
            </div>

            <hr style="margin: 2rem 0; border-color: #f0e6d2;">

            {{-- Detail Produk --}}
            <h3 style="color:#8B5E3C; margin-bottom:1rem;">Detail Produk</h3>

            <table class="tabel-produk" id="tabel-produk">
                <thead>
                    <tr>
                        <th>Produk</th>
                        <th>Jumlah</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody id="produk-body">
                    <tr>
                        <td>
                            <select name="products[0][id]" required>
                                <option value="">-- Pilih Produk --</option>
                                @foreach ($products as $product)
                                    <option value="{{ $product->id }}">
                                        {{ $product->title }} (Stok: {{ $product->stock }})
                                    </option>
                                @endforeach
                            </select>
                        </td>
                        <td>
                            <input type="number" name="products[0][jumlah]" min="1" value="1" required>
                        </td>
                        <td class="aksi-cell">
                            <button type="button" class="tombol tombol--hapus" onclick="hapusBaris(this)">Hapus</button>
                        </td>
                    </tr>
                </tbody>
            </table>

            <div class="tambah-produk">
                <button type="button" class="tombol tombol--utama" style="background-color:#A2B38B;" onclick="tambahBaris()">+ Tambah Produk</button>
            </div>

            {{-- Tombol Aksi --}}
            <div class="tombol-aksi">
                <a href="{{ route('transaksi.index') }}" class="tombol tombol--batal">Batal</a>
                <button type="submit" class="tombol tombol--utama">Simpan Transaksi</button>
            </div>
        </form>
    </div>
</div>

<script>
let index = 1;

function tambahBaris() {
    const tbody = document.getElementById('produk-body');
    const row = document.createElement('tr');
    row.innerHTML = `
        <td>
            <select name="products[${index}][id]" required>
                <option value="">-- Pilih Produk --</option>
                @foreach ($products as $product)
                    <option value="{{ $product->id }}">
                        {{ $product->title }} (Stok: {{ $product->stock }})
                    </option>
                @endforeach
            </select>
        </td>
        <td>
            <input type="number" name="products[${index}][jumlah]" min="1" value="1" required>
        </td>
        <td class="aksi-cell">
            <button type="button" class="tombol tombol--hapus" onclick="hapusBaris(this)">Hapus</button>
        </td>
    `;
    tbody.appendChild(row);
    index++;
}

function hapusBaris(button) {
    const row = button.closest('tr');
    const tbody = document.getElementById('produk-body');
    if (tbody.rows.length > 1) {
        row.remove();
    }
}
</script>

<style>
.halaman-penuh {
    background-color: #FFF8E7;
    padding: 3rem 4rem;
    min-height: 100vh;
    display: flex;
    flex-direction: column;
    align-items: center;
}

.header-tambah {
    text-align: center;
    margin-bottom: 2rem;
}
.header-tambah h1 {
    color: #8B5E3C;
    font-size: 2.2rem;
    font-weight: 700;
    margin-bottom: 0.3rem;
}
.header-tambah p {
    color: #9B7B5C;
    font-size: 1rem;
}

.kartu-form {
    background: #ffffff;
    border-radius: 20px;
    padding: 2.5rem 3rem;
    box-shadow: 0 10px 25px rgba(0,0,0,0.05);
    width: 90%;
    max-width: 900px;
}

.formulir-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 1.2rem;
}

.grup-formulir { margin-bottom: 1.3rem; }
label {
    display: block;
    font-weight: 600;
    color: #8B5E3C;
    margin-bottom: 0.4rem;
}
input, select {
    width: 100%;
    border: 1px solid #ddd;
    border-radius: 10px;
    padding: 0.7rem;
    font-size: 1rem;
}
textarea { resize: none; }

.tabel-produk {
    width: 100%;
    border-collapse: collapse;
    margin-bottom: 1.5rem;
}
.tabel-produk th, .tabel-produk td {
    border-bottom: 1px solid #eee;
    padding: 0.8rem;
    text-align: left;
}
.tabel-produk th {
    background-color: #faf6ef;
    color: #8B5E3C;
    text-transform: uppercase;
    font-size: 0.9rem;
}
.tabel-produk tr:hover {
    background-color: #fff9f1;
}
.aksi-cell {
    text-align: center;
}

.tambah-produk {
    text-align: left;
    margin-top: 1rem;
}

.tombol-aksi {
    text-align: right;
    margin-top: 2rem;
    display: flex;
    justify-content: flex-end;
    gap: 1rem;
}

.tombol {
    display: inline-block;
    padding: 0.8rem 1.6rem;
    border-radius: 10px;
    font-weight: 600;
    text-decoration: none;
    cursor: pointer;
    transition: 0.2s ease;
    border: none;
}
.tombol--utama {
    background-color: #D4A017;
    color: white;
}
.tombol--utama:hover { background-color: #c4950f; }
.tombol--batal {
    background-color: #f2f2f2;
    color: #555;
}
.tombol--batal:hover { background-color: #e0e0e0; }
.tombol--hapus {
    background-color: rgba(220, 53, 69, 0.1);
    color: #dc3545;
}
.tombol--hapus:hover {
    background-color: rgba(220, 53, 69, 0.2);
}

.pesan-error {
    color: #cc0000;
    font-size: 0.85rem;
    margin-top: 0.3rem;
}
</style>
@endsection