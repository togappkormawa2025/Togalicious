{{-- resources/views/admin/statistics/index.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="p-6 bg-gray-50 min-h-screen">
    <h1 class="text-3xl font-bold mb-6 text-gray-800">📊 Statistik & Laporan Keuangan</h1>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Statistik Produk Terlaris -->
        <div class="bg-white rounded-2xl shadow-md p-6 border border-gray-100 hover:shadow-lg transition">
            <h2 class="text-xl font-semibold mb-4 text-indigo-600">🔥 Produk Terlaris</h2>
            <canvas id="topProductsChart" class="w-full h-64"></canvas>
        </div>

        <!-- Statistik Keuangan -->
        <div class="bg-white rounded-2xl shadow-md p-6 border border-gray-100 hover:shadow-lg transition">
            <h2 class="text-xl font-semibold mb-4 text-green-600">💰 Laporan Keuangan</h2>
            <canvas id="financeChart" class="w-full h-64"></canvas>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Data Produk Terlaris
    const productLabels = @json($topProducts->pluck('name'));
    const productData   = @json($topProducts->pluck('total_sold'));

    new Chart(document.getElementById('topProductsChart'), {
        type: 'bar',
        data: {
            labels: productLabels,
            datasets: [{
                label: 'Jumlah Terjual',
                data: productData,
                backgroundColor: 'rgba(99, 102, 241, 0.7)', // indigo-500
                borderRadius: 8,
            }]
        },
        options: {
            responsive: true,
            plugins: { legend: { display: false } },
            scales: {
                y: { beginAtZero: true }
            }
        }
    });

    // Data Keuangan
    const financeLabels = ['Total Transaksi', 'Total Diskon'];
    const financeData   = [{{ $totalRevenue }}, {{ $totalDiscount }}];

    new Chart(document.getElementById('financeChart'), {
        type: 'doughnut',
        data: {
            labels: financeLabels,
            datasets: [{
                data: financeData,
                backgroundColor: [
                    'rgba(34,197,94,0.8)',   // green
                    'rgba(239,68,68,0.8)'   // red
                ],
                borderWidth: 2,
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { position: 'bottom' }
            }
        }
    });
</script>
@endsection
