@extends('layouts.app')
@section('page-title', 'Dashboard')

@section('content')
<style>
    body {
        background-color: #FFF8F0;
    }
    .dashboard-container {
        background: linear-gradient(to bottom, #FFF8F0, #FFF3E0);
        padding: 40px;
        border-radius: 20px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.05);
    }
    .dashboard-title {
        font-weight: 700;
        color: #6B4226;
        font-size: 2rem;
        margin-bottom: 1rem;
    }
    .dashboard-subtitle {
        color: #A97455;
        font-size: 1.1rem;
        margin-bottom: 2rem;
    }
    .stat-card {
        background-color: #FFFFFF;
        border-radius: 16px;
        border: none;
        box-shadow: 0 3px 8px rgba(0,0,0,0.05);
        transition: all 0.2s ease-in-out;
    }
    .stat-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 6px 14px rgba(0,0,0,0.1);
    }
    .stat-card h5 {
        color: #A97455;
        font-weight: 500;
        margin-bottom: 0.5rem;
    }
    .stat-card h2 {
        font-weight: 700;
        color: #6B4226;
        font-size: 2rem;
    }
    /* Tambahan untuk grafik */
    .chart-card {
        background-color: #FFFFFF;
        padding: 20px;
        border-radius: 16px;
        box-shadow: 0 3px 8px rgba(0,0,0,0.05);
        height: 380px;
    }
    .chart-card canvas {
        max-height: 260px;
    }
</style>

<div class="dashboard-container">
    <h1 class="dashboard-title">Selamat Datang di Dashboard Pawfect 🐾</h1>
    <p class="dashboard-subtitle">Pantau performa toko Anda di sini</p>

    <!-- Statistik Kartu -->
    <div class="row g-4 mb-4">
        <div class="col-md-3">
            <div class="card stat-card text-center p-4">
                <h5>Total Produk</h5>
                <h2>{{ $totalProducts }}</h2>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card stat-card text-center p-4">
                <h5>Total Supplier</h5>
                <h2>{{ $totalSuppliers }}</h2>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card stat-card text-center p-4">
                <h5>Total Transaksi</h5>
                <h2>{{ $totalTransactions }}</h2>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card stat-card text-center p-4">
                <h5>Produk Terjual</h5>
                <h2>{{ $totalSoldProducts }}</h2>
            </div>
        </div>
    </div>

    <!-- Grafik Bagian Bawah -->
    <div class="row g-4 mt-2">
        <!-- Grafik Penjualan Bulanan -->
        <div class="col-md-6">
            <div class="chart-card">
                <h2 class="text-lg font-semibold text-center mb-3 text-[#6B3E2E]">Grafik Penjualan Bulanan</h2>
                <canvas id="salesChart"></canvas>
            </div>
        </div>

        <!-- Grafik Produk per Kategori -->
        <div class="col-md-6">
            <div class="chart-card">
                <h2 class="text-lg font-semibold text-center mb-3 text-[#6B3E2E]">Distribusi Produk per Kategori</h2>
                <canvas id="categoryChart"></canvas>
            </div>
        </div>
    </div>
</div>

<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const months = @json($months);
    const salesData = @json($salesData);
    const categoryLabels = @json(array_keys($productByCategory));
    const categoryValues = @json(array_values($productByCategory));

    // === Grafik Penjualan Bulanan ===
    new Chart(document.getElementById('salesChart'), {
        type: 'line',
        data: {
            labels: months,
            datasets: [{
                label: 'Jumlah Transaksi',
                data: salesData,
                borderColor: '#C97C5D',
                backgroundColor: 'rgba(201, 124, 93, 0.2)',
                fill: true,
                tension: 0.3,
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { legend: { display: false } },
            scales: { y: { beginAtZero: true } }
        }
    });

    // === Grafik Produk per Kategori ===
    new Chart(document.getElementById('categoryChart'), {
        type: 'doughnut',
        data: {
            labels: categoryLabels,
            datasets: [{
                data: categoryValues,
                backgroundColor: ['#C97C5D', '#EABF9F', '#A97155', '#8D493A', '#E6B8A2'],
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { legend: { position: 'bottom' } }
        }
    });
</script>
@endsection
