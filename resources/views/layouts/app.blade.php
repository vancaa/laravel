<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pawfect Manajemen Sistem</title>

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@600&family=Nunito+Sans:wght@400;600&display=swap" rel="stylesheet">

    <!-- Bootstrap & Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="shortcut icon" href="{{ asset('storage/image/pawfect-logo.png') }}" type="image/x-icon">

    <style>
        :root {
            --warna-utama: #B57F50;
            --warna-sekunder: #A2B38B;
            --warna-aksen: #D4AF37;
            --warna-latar: #FFF8E7;
            --teks-gelap: #333;
            --teks-terang: #FFF;
            --font-utama: 'Nunito Sans', sans-serif;
            --font-judul: 'Poppins', sans-serif;
            --bayangan: 0 4px 24px rgba(181, 127, 80, 0.08);
            --transisi: all 0.3s ease;
        }

        body {
            font-family: var(--font-utama);
            background-color: var(--warna-latar);
            color: var(--teks-gelap);
        }

        /* SIDEBAR */
        .sidebar {
            width: 250px;
            height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            background-color: var(--warna-utama);
            color: var(--teks-terang);
            display: flex;
            flex-direction: column;
            padding: 2rem 0;
            box-shadow: var(--bayangan);
            transition: transform 0.3s ease-in-out;
            z-index: 2000;
        }
        .sidebar.hidden {
            transform: translateX(-100%);
        }

        .logo {
            text-align: center;
            margin-bottom: 2rem;
        }
        .logo-img {
            width: 100px;
            margin-top: 0.5rem;
            border-radius: 12px;
        }

        .sidebar a {
            color: var(--teks-terang);
            display: block;
            text-decoration: none;
            padding: 1rem 2rem;
            margin: 0.3rem 1rem;
            border-radius: 12px;
            transition: var(--transisi);
        }
        .sidebar a:hover,
        .sidebar a.active {
            background-color: rgba(255, 255, 255, 0.15);
            transform: translateX(5px);
        }

        .logout-btn {
            width: 70%;
            background: #fff;
            border: none;
            color: var(--warna-utama);
            font-family: var(--font-utama);
            font-size: 1rem;
            font-weight: 600;
            text-align: left;
            padding: 0.9rem 1.5rem;
            border-radius: 12px;
            transition: var(--transisi);
            display: flex;
            align-items: center;
            gap: 10px;
            box-shadow: 0 3px 8px rgba(0, 0, 0, 0.08);
        }
        .logout-btn:hover {
            background-color: #f7f7f7;
            color: var(--warna-aksen);
            transform: translateY(-2px);
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.12);
        }
        .logout-form {
    padding: 0 1rem;
    margin-top: auto;
    display: flex;
    justify-content: flex-start;
}
.logout-form {
    padding: 0 1rem;
    margin-top: auto;
    display: flex;
    justify-content: flex-start;
}

.logout-link {
    background-color: #ffffff;
    border: none;
    color: var(--warna-utama);
    width: 100%; /* sedikit lebih kecil */
    margin-left: 0.5cm; /* 🔹 mundur sedikit dari sebelumnya (1cm → 0.5cm) */
    text-align: left;
    padding: 0.55rem 1rem; /* tombol sedikit lebih kecil */
    border-radius: 10px;
    font-size: 0.95rem;
    font-weight: 600;
    display: flex;
    align-items: center;
    gap: 10px;
    transition: var(--transisi);
    box-shadow: 0 2px 6px rgba(0, 0, 0, 0.08);
}

.logout-link i {
    font-size: 1.2rem;
}

.logout-link:hover {
    background-color: var(--warna-sekunder);
    color: #fff;
    transform: translateY(-2px);
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.12);
}

        /* TOGGLE BUTTON */
        .menu-toggle {
            display: none;
            position: fixed;
            top: 15px;
            left: 15px;
            background-color: var(--warna-utama);
            color: white;
            border: none;
            border-radius: 8px;
            padding: 8px 12px;
            z-index: 2100;
            box-shadow: var(--bayangan);
        }
        .menu-toggle:hover {
            background-color: #a76f44;
        }

        /* KONTEN */
        .content {
            margin-left: 250px;
            padding: 2rem;
            transition: margin-left 0.3s ease;
        }
        @media (max-width: 768px) {
            .menu-toggle { display: block; }
            .sidebar { transform: translateX(-100%); }
            .sidebar.show { transform: translateX(0); }
            .content { margin-left: 0; padding-top: 60px; }
        }

        footer {
            text-align: center;
            padding: 2rem;
            color: #aaa;
            font-size: 0.9rem;
        }
    </style>
</head>

<body>
    <!-- Tombol Menu (Mobile) -->
    <button class="menu-toggle" id="menuToggle">
        <i class="bi bi-list" style="font-size: 1.5rem;"></i>
    </button>

    <!-- SIDEBAR -->
    <div class="sidebar" id="sidebar">
        <div class="logo">
            <h4>Pawfect</h4>
            <p>Manajemen Sistem</p>
            <img src="{{ asset('storage/image/pawfect-logo.png') }}" alt="Logo Pawfect" class="logo-img">
        </div>

        <a href="{{ url('/dashboard') }}" class="{{ request()->is('dashboard*') ? 'active' : '' }}">
            <i class="bi bi-speedometer2"></i> Dashboard
        </a>
        <a href="{{ url('/products') }}" class="{{ request()->is('products*') ? 'active' : '' }}">
            <i class="bi bi-box"></i> Products
        </a>
        <a href="{{ url('/suppliers') }}" class="{{ request()->is('suppliers*') ? 'active' : '' }}">
            <i class="bi bi-truck"></i> Supplier
        </a>
        <a href="{{ url('/categories') }}" class="{{ request()->is('categories*') ? 'active' : '' }}">
            <i class="bi bi-tags"></i> Kategori Produk
        </a>
        <a href="{{ url('/transaksi') }}" class="{{ request()->is('transaksi*') ? 'active' : '' }}">
            <i class="bi bi-cash-stack"></i> Transaksi
        </a>

       <form action="{{ route('logout') }}" method="POST" class="logout-form mt-auto">
    @csrf
    <button type="submit" class="logout-link w-100 text-start">
        <i class="bi bi-box-arrow-right me-2"></i> Logout
    </button>
</form>

    </div>

    <!-- KONTEN -->
    <div class="content">
        @yield('content')
        <footer>&copy; 2025 Pawfect Supplies</footer>
    </div>

    <!-- Script -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Toggle sidebar untuk mobile
        const menuToggle = document.getElementById('menuToggle');
        const sidebar = document.getElementById('sidebar');
        menuToggle.addEventListener('click', () => {
            sidebar.classList.toggle('show');
        });
    </script>

    @yield('scripts')
</body>
</html>
