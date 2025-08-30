@extends('layouts.admin')

@section('content')
<div class="p-6">
  <h2 class="text-2xl font-bold text-asparagus mb-6">Dashboard</h2>

  <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
    <!-- Produk per Kategori -->
    <div class="bg-white p-4 rounded shadow">
      <h3 class="font-bold mb-2">Jumlah Produk per Kategori</h3>
      <canvas id="produkKategoriChart"></canvas>
    </div>

    <!-- User per Role -->
    <div class="bg-white p-4 rounded shadow">
      <h3 class="font-bold mb-2">Jumlah User per Role</h3>
      <canvas id="userRoleChart"></canvas>
    </div>
  </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
  // Grafik Produk per Kategori
  const produkChart = new Chart(document.getElementById('produkKategoriChart'), {
    type: 'bar',
    data: {
      labels: {!! json_encode($labels) !!}, // kategori
      datasets: [{
        label: 'Jumlah Produk',
        data: {!! json_encode($data) !!}, // jumlah produk
        backgroundColor: '#8fc93a'
      }]
    },
    options: {
      responsive: true,
      scales: {
        y: { beginAtZero: true }
      }
    }
  });

  // Grafik User per Role
  const userChart = new Chart(document.getElementById('userRoleChart'), {
    type: 'pie',
    data: {
      labels: {!! json_encode($userLabels) !!}, // role
      datasets: [{
        label: 'Jumlah User',
        data: {!! json_encode($userData) !!}, // jumlah user
        backgroundColor: ['#00bcd4', '#ff6f61']
      }]
    },
    options: {
      responsive: true
    }
  });
</script>
@endsection
