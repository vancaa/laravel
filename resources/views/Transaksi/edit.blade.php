@markdown:View Edit Transaksi (dengan field email_pembeli):resources/views/transaksi/edit.blade.php
@extends('layouts.app')
@section('judulHalaman', 'Edit Transaksi')

@section('content')
<div class="halaman-penuh">
    <div class="header-tambah">
        <div>
            <h1>Edit Transaksi</h1>
            <p>Perbarui detail untuk transaksi <strong>#TRX-{{ $transaksi->id }}</strong>. Email akan dikirim ulang setelah diperbarui.</p>
        </div>
    </div>

    <div class="kartu-form">
        <form action="{{ route('transaksi.update', $transaksi->id) }}" method="POST">
            @csrf
            @method('PUT')

            {{-- PENTING: Pembungkus Grid Baru --}}
            <div class="formulir-grid"> 
                {{-- Nama Kasir --}}
                <div class="grup-formulir">
                    <label for="nama_kasir">Nama Kasir</label>
                    <input 
                        type="text" 
                        id="nama_kasir" 
                        name="nama_kasir" 
                        value="{{ old('nama_kasir', $transaksi->nama_kasir) }}" 
                        required>
                    @error('nama_kasir')<div class="pesan-error">{{ $message }}</div>@enderror
                </div>

                {{-- Email Pembeli (Sisipan Tugas) --}}
                <div class="grup-formulir">
                    <label for="email_pembeli">Email Pembeli (untuk Kirim Email)</label>
                    <input 
                        type="email" 
                        id="email_pembeli" 
                        name="email_pembeli" 
                        value="{{ old('email_pembeli', $transaksi->email_pembeli) }}">
                    @error('email_pembeli')<div class="pesan-error">{{ $message }}</div>@enderror
                </div>
            </div> {{-- Penutup Grid --}}

            <hr class="pemisah">

            <p class="catatan">
                <strong>Catatan:</strong> Mengubah detail item transaksi tidak diizinkan di sini demi menjaga integritas data.
                Jika ada kesalahan pada item, silakan hapus transaksi dan buat ulang.
            </p>

            {{-- Tombol --}}
            <div class="tombol-aksi">
                <a href="{{ route('transaksi.index') }}" class="tombol tombol--batal">Batal</a>
                <button type="submit" class="tombol tombol--utama">Perbarui Transaksi</button>
            </div>
        </form>
    </div>
</div>

<style>
/* CSS di sini TIDAK BERUBAH kecuali penambahan class formulir-grid */
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
    max-width: 700px;
}

/* SISIPAN STYLE BARU: Formulir Grid */
.formulir-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 1.2rem;
}
/* END SISIPAN STYLE BARU */

.grup-formulir { margin-bottom: 1.3rem; }
label {
    display: block;
    font-weight: 600;
    color: #8B5E3C;
    margin-bottom: 0.4rem;
}
input {
    width: 100%;
    border: 1px solid #ddd;
    border-radius: 10px;
    padding: 0.7rem;
    font-size: 1rem;
}
input:focus {
    outline: none;
    border-color: #D4A017;
}

.pemisah {
    border: none;
    border-top: 1px solid #eee;
    margin: 1.5rem 0;
}

.catatan {
    font-size: 0.95rem;
    color: #9B7B5C;
    background: #FFF3D4;
    padding: 1rem;
    border-radius: 10px;
}

.tombol-aksi {
    text-align: right;
    margin-top: 1.8rem;
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

.pesan-error {
    color: #cc0000;
    font-size: 0.85rem;
    margin-top: 0.3rem;
}
</style>
@endsection

