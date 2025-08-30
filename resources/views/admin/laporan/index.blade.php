@extends('layouts.admin')

@section('content')
<div class="p-6 space-y-6">

    <!-- Judul -->
    <div class="flex justify-between items-center">
        <h1 class="text-3xl font-extrabold text-gray-800">📊 Laporan Keuangan</h1>
    </div>

    <!-- Filter -->
    <div class="bg-white p-4 rounded-xl shadow-md border border-gray-200">
        <form method="GET" class="flex flex-wrap gap-4 items-end">
            <div>
                <label for="bulan" class="block text-sm font-medium text-gray-600">Bulan</label>
                <select name="bulan" id="bulan"
                    class="mt-1 border-gray-300 rounded-lg px-3 py-2 shadow-sm focus:ring focus:ring-blue-300">
                    @for($i = 1; $i <= 12; $i++)
                        <option value="{{ sprintf('%02d', $i) }}" {{ $bulan == sprintf('%02d', $i) ? 'selected' : '' }}>
                            {{ DateTime::createFromFormat('!m', $i)->format('F') }}
                        </option>
                    @endfor
                </select>
            </div>

            <div>
                <label for="tahun" class="block text-sm font-medium text-gray-600">Tahun</label>
                <input type="number" name="tahun" id="tahun" value="{{ $tahun }}"
                    class="mt-1 border-gray-300 rounded-lg px-3 py-2 shadow-sm focus:ring focus:ring-blue-300 w-32">
            </div>

            <button type="submit"
                class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg shadow font-medium transition">
                🔍 Filter
            </button>
        </form>
    </div>

    <!-- Ringkasan -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-gradient-to-r from-green-100 to-green-200 p-5 rounded-xl shadow hover:scale-105 transition">
            <p class="text-sm text-gray-600">Total Pendapatan</p>
            <p class="text-2xl font-bold text-green-700 mt-1">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</p>
        </div>
        <div class="bg-gradient-to-r from-yellow-100 to-yellow-200 p-5 rounded-xl shadow hover:scale-105 transition">
            <p class="text-sm text-gray-600">Total Diskon</p>
            <p class="text-2xl font-bold text-yellow-700 mt-1">Rp {{ number_format($totalDiskon, 0, ',', '.') }}</p>
        </div>
        <div class="bg-gradient-to-r from-blue-100 to-blue-200 p-5 rounded-xl shadow hover:scale-105 transition">
            <p class="text-sm text-gray-600">Total Pembayaran</p>
            <p class="text-2xl font-bold text-blue-700 mt-1">Rp {{ number_format($totalBayar, 0, ',', '.') }}</p>
        </div>
    </div>

    <!-- Tombol Export -->
    <div class="flex justify-between mt-6">
        <a href="{{ route('admin.reports.create') }}"
           class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded-lg shadow font-medium transition flex items-center gap-2">
            ➕ Tambah Laporan
        </a>

        <a href="{{ route('laporan.export.excel', ['bulan' => $bulan, 'tahun' => $tahun]) }}"
           class="bg-green-600 hover:bg-green-700 text-white px-5 py-2 rounded-lg shadow font-medium transition flex items-center gap-2">
            ⬇️ Export Excel
        </a>
    </div>

    <!-- Tabel Transaksi -->
    <div class="bg-white rounded-xl shadow-md border border-gray-200 overflow-hidden mt-4">
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left">
                <thead class="bg-gray-100 text-gray-700 uppercase text-xs font-semibold">
                    <tr>
                        <th class="px-4 py-3">Tanggal</th>
                        <th class="px-4 py-3">Kasir</th>
                        <th class="px-4 py-3">Customer</th>
                        <th class="px-4 py-3 text-right">Total</th>
                        <th class="px-4 py-3 text-right">Diskon</th>
                        <th class="px-4 py-3 text-right">Bayar</th>
                        <th class="px-4 py-3 text-right">Kembalian</th>
                        <th class="px-4 py-3 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($laporan as $row)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-4 py-3">{{ $row->created_at->format('d M Y H:i') }}</td>
                            <td class="px-4 py-3 font-medium text-gray-800">{{ $row->cashier }}</td>
                            <td class="px-4 py-3">{{ $row->customer ?? '-' }}</td>
                            <td class="px-4 py-3 text-right font-semibold text-gray-800">
                                Rp {{ number_format($row->total, 0, ',', '.') }}
                            </td>
                            <td class="px-4 py-3 text-right text-yellow-700">
                                Rp {{ number_format($row->discount, 0, ',', '.') }}
                            </td>
                            <td class="px-4 py-3 text-right text-green-700">
                                Rp {{ number_format($row->pay, 0, ',', '.') }}
                            </td>
                            <td class="px-4 py-3 text-right text-blue-700">
                                Rp {{ number_format($row->change, 0, ',', '.') }}
                            </td>
                            <td class="px-4 py-3 text-center">
                                <div class="flex justify-center gap-2">
                                    <!-- Show -->
                                    <a href="{{ route('admin.reports.show', $row->id) }}"
                                       class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded-lg text-xs">
                                        🔍 Lihat
                                    </a>
                                    <!-- Edit -->
                                    <a href="{{ route('admin.reports.edit', $row->id) }}"
                                       class="bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-1 rounded-lg text-xs">
                                        ✏️ Edit
                                    </a>
                                    <!-- Delete -->
                                    <form action="{{ route('admin.reports.destroy', $row->id) }}" method="POST"
                                          onsubmit="return confirm('Yakin ingin menghapus laporan ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded-lg text-xs">
                                            🗑 Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center py-6 text-gray-500">Tidak ada transaksi.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
