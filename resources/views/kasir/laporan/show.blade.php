@extends('layouts.app')

@section('content')
<div class="p-6 space-y-6 max-w-3xl mx-auto">
    <h1 class="text-2xl font-bold text-gray-800 mb-4">👁 Detail Transaksi</h1>

    <div class="bg-white p-6 rounded-xl shadow space-y-4">
        <div class="grid grid-cols-2 gap-4">
            <p><span class="font-semibold">Kasir:</span> {{ $report->cashier }}</p>
            <p><span class="font-semibold">Customer:</span> {{ $report->customer ?? '-' }}</p>
            <p><span class="font-semibold">Total:</span> Rp {{ number_format($report->total, 0, ',', '.') }}</p>
            <p><span class="font-semibold">Diskon:</span> Rp {{ number_format($report->discount, 0, ',', '.') }}</p>
            <p><span class="font-semibold">Bayar:</span> Rp {{ number_format($report->pay, 0, ',', '.') }}</p>
            <p><span class="font-semibold">Kembalian:</span> Rp {{ number_format($report->change, 0, ',', '.') }}</p>
            <p><span class="font-semibold">Tanggal:</span> {{ $report->created_at->format('d M Y H:i') }}</p>
        </div>

        <div class="flex justify-end space-x-3">
            <a href="{{ route('kasir.reports.edit', $report->id) }}"
                class="px-4 py-2 rounded-lg bg-yellow-500 hover:bg-yellow-600 text-white">✏ Edit</a>
            <form action="{{ route('kasir.reports.destroy', $report->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus?')">
                @csrf
                @method('DELETE')
                <button type="submit"
                    class="px-4 py-2 rounded-lg bg-red-600 hover:bg-red-700 text-white">🗑 Hapus</button>
            </form>
            <a href="{{ route('kasir.reports.index') }}"
                class="px-4 py-2 rounded-lg bg-gray-300 hover:bg-gray-400 text-gray-800">⬅ Kembali</a>
        </div>
    </div>
</div>
@endsection
