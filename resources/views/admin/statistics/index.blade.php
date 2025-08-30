{{-- resources/views/admin/statistics/index.blade.php --}}
@extends('layouts.admin')

@section('content')
<div class="p-6 bg-gray-50 min-h-screen">
    <h1 class="text-3xl font-bold mb-6 text-gray-800">📊 Statistik & Laporan Keuangan</h1>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Statistik Produk Terlaris -->
        <div class="bg-white rounded-2xl shadow-md p-6 border border-gray-100 hover:shadow-lg transition">
            <h2 class="text-xl font-semibold mb-4 text-indigo-600">🔥 Produk Terlaris</h2>
            <ul class="space-y-2">
                @foreach ($topProducts as $product)
                    <li class="flex justify-between items-center p-2 rounded-lg hover:bg-indigo-50">
                        <span class="font-medium text-gray-700">{{ $product->name }}</span>
                        <span class="text-sm text-gray-500">{{ $product->total_sold }} terjual</span>
                    </li>
                @endforeach
            </ul>
        </div>

        <!-- Statistik Keuangan -->
        <div class="bg-white rounded-2xl shadow-md p-6 border border-gray-100 hover:shadow-lg transition">
            <h2 class="text-xl font-semibold mb-4 text-green-600">💰 Laporan Keuangan</h2>
            <div class="space-y-3">
                <div class="flex justify-between items-center p-2 rounded-lg hover:bg-green-50">
                    <span class="font-medium text-gray-700">Total Transaksi</span>
                    <span class="text-gray-800 font-semibold">Rp{{ number_format($totalRevenue) }}</span>
                </div>
                <div class="flex justify-between items-center p-2 rounded-lg hover:bg-red-50">
                    <span class="font-medium text-gray-700">Total Diskon</span>
                    <span class="text-red-600 font-semibold">Rp{{ number_format($totalDiscount) }}</span>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
