@extends('layouts.app')
@section('content')

<style>
    :root {
        --warna-utama: #B57F50;
        --warna-sekunder: #A2B38B;
        --warna-aksen: #D4AF37;
        --warna-bahaya: #dc3545;
        --teks-gelap: #333;
        --transisi: all 0.3s ease;
        --bayangan: 0 4px 24px rgba(181, 127, 80, 0.08);
    }
    .kartu {
        background: #fff; border-radius: 16px; padding: 2rem;
        box-shadow: var(--bayangan); margin-top: 1.5rem;
    }
    .kartu__judul {
        font-family: 'Poppins', sans-serif;
        color: var(--warna-utama);
        font-size: 1.5rem;
        margin-bottom: 1.5rem;
    }
    .tabel {
        width: 100%; border-collapse: collapse;
    }
    .tabel th, .tabel td {
        padding: 1.25rem 1rem;
        text-align: left;
        border-bottom: 1px solid #f0f0f0;
    }
    .tabel th {
        color: var(--warna-sekunder);
        font-size: 0.8rem;
        text-transform: uppercase;
    }
    .tabel tr:hover { background: #fafafa; }
    .tabel .harga { font-weight: 600; color: var(--warna-utama); }
    .tabel .grup-tombol-aksi { display: flex; gap: 0.5rem; }

    .tombol {
        padding: 0.6rem 1.2rem;
        border: none; border-radius: 8px;
        font-size: 0.85rem; font-weight: 600;
        cursor: pointer; transition: var(--transisi);
        text-decoration: none;
    }
    .tombol:hover { transform: translateY(-2px); }
    .tombol--utama { background: var(--warna-aksen); color: white; box-shadow: 0 4px 12px rgba(212, 175, 55, 0.3); }
    .tombol--lihat {
    background: rgba(30, 144, 255, 0.15); /* biru lembut transparan */
    color: #1e90ff;
}
.tombol--lihat:hover {
    background: rgba(30, 144, 255, 0.25);
}
    .tombol--edit { background: rgba(212, 175, 55, 0.1); color: var(--warna-aksen); }
    .tombol--hapus { background: rgba(220, 53, 69, 0.1); color: var(--warna-bahaya); }
    /* container already pake bootstrap util, tapi pastikan pagination tanpa top margin */
/* 🎨 Ubah warna pagination jadi tema coklat */
.pagination .page-link {
    color: var(--warna-utama); /* teks nomor halaman */
    border: 1px solid #ddd;
    border-radius: 6px;
    margin: 0 4px;
    transition: var(--transisi);
}

.pagination .page-link:hover {
    background-color: rgba(181, 127, 80, 0.15); /* coklat lembut pas hover */
    color: var(--warna-utama);
    border-color: var(--warna-utama);
}

.pagination .page-item.active .page-link {
    background-color: var(--warna-utama); /* coklat tua aktif */
    color: #fff;
    border-color: var(--warna-utama);
}

.pagination .page-item.disabled .page-link {
    color: #ccc;
    background-color: #f8f8f8;
    border-color: #eee;
}

</style>

<header class="header" style="display:flex; justify-content:space-between; align-items:center; margin-bottom:1rem;">
    <div>
        <h1 style="font-family:'Poppins',sans-serif; color:var(--warna-utama); font-size:2rem;">Manajemen Produk</h1>
        <p>Kelola semua produk Anda di sini</p>
    </div>
    <a href="{{ route('products.create') }}" class="tombol tombol--utama">+ Tambah Produk</a>
</header>

<div class="kartu">
    <h2 class="kartu__judul">Daftar Produk</h2>
    <table class="tabel">
        <thead>
            <tr>
                <th>Gambar</th>
                <th>Nama Produk</th>
                <th>Kategori</th>
                <th>Supplier</th>
                <th>Stok</th>
                <th>Harga</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
    @forelse($products as $product)
        <tr>
            <td>
                <img src="{{ asset('storage/image/' . $product->image) }}" alt="gambar" width="60" style="border-radius:8px;">
            </td>
            <td>{{ $product->title }}</td>
            <td>{{ $product->category->product_category_name ?? '-' }}</td>
            <td>{{ $product->supplier->supplier_name ?? '-' }}</td>
            <td>{{ $product->stock }}</td>
            <td class="harga">Rp{{ number_format($product->price, 0, ',', '.') }}</td>
            <td>
                        <div class="grup-tombol-aksi">
                        <a href="{{ route('products.show', $product->id) }}" class="tombol tombol--lihat">Lihat</a>
                            <a href="{{ route('products.edit', $product->id) }}" class="tombol tombol--edit">Edit</a>
                            <form action="{{ route('products.destroy', $product->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="tombol tombol--hapus">Hapus</button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" style="text-align:center; padding:2rem;">Belum ada produk. Silakan tambahkan.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
<div class="d-flex justify-content-center align-items-center mt-4 mb-3">
    <nav aria-label="Page navigation">
        {{ $products->links('pagination::bootstrap-5') }}
    </nav>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    // Tangkap semua form hapus
    const forms = document.querySelectorAll('form[method="POST"][action*="products"]');
    
    forms.forEach(form => {
        form.addEventListener('submit', function (e) {
            e.preventDefault();

            Swal.fire({
                title: 'Yakin ingin menghapus produk ini?',
                text: "Data yang dihapus tidak dapat dikembalikan!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#D4A017',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, hapus',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    });
});
</script>

{{-- Notifikasi sukses --}}
@if(session('success'))
<script>
Swal.fire({
    icon: 'success',
    title: 'Berhasil!',
    text: '{{ session('success') }}',
    showConfirmButton: false,
    timer: 2000
});
</script>
@endif
@endsection