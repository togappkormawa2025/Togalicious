@extends('layouts.admin')

@section('content')
<div class="p-6">
    <h1 class="text-2xl font-bold mb-6 text-gray-800">Detail Transaksi</h1>

    <!-- Info Transaksi -->
    <div class="bg-white shadow rounded-lg p-6 mb-6">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div>
                <p class="text-sm text-gray-500">Tanggal</p>
                <p class="text-gray-800 font-semibold">{{ $transaction->created_at->format('d M Y H:i') }}</p>
            </div>
            <div>
                <p class="text-sm text-gray-500">Total</p>
                <p class="text-green-600 font-bold text-lg">Rp {{ number_format($transaction->total, 0, ',', '.') }}</p>
            </div>
            <div>
                <p class="text-sm text-gray-500">User</p>
<p class="text-gray-800 font-semibold">{{ $transaction->cashier ?? '-' }}</p>
            </div>
        </div>
    </div>

    <!-- Daftar Produk -->
    <div class="bg-white shadow rounded-lg p-6">
        <h2 class="text-xl font-semibold mb-4 text-gray-800">Produk</h2>
        <div class="overflow-x-auto">
            <table class="w-full text-left border border-gray-200 rounded-lg overflow-hidden">
                <thead>
                    <tr class="bg-gray-100 text-gray-700 text-sm uppercase">
                        <th class="px-4 py-3">Nama Produk</th>
                        <th class="px-4 py-3">Harga</th>
                        <th class="px-4 py-3 text-center">Qty</th>
                        <th class="px-4 py-3">Subtotal</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @foreach ($transaction->details as $detail)
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-3">{{ $detail->product->name }}</td>
                            <td class="px-4 py-3">Rp {{ number_format($detail->price, 0, ',', '.') }}</td>
                            <td class="px-4 py-3 text-center">{{ $detail->qty }}</td>
                            <td class="px-4 py-3 font-medium">Rp {{ number_format($detail->price * $detail->qty, 0, ',', '.') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Tombol Kembali -->
    <div class="mt-6">
        <a href="{{ route('admin.transactions.index') }}"
           class="inline-block bg-gray-600 text-white px-4 py-2 rounded-lg shadow hover:bg-gray-700 transition">
           ← Kembali
        </a>
    </div>
</div>
@endsection
