@extends('layouts.app')

@section('content')
<div class="p-6 max-w-3xl mx-auto">
    <div class="bg-white p-8 rounded-2xl shadow-lg border border-gray-100">
        <h1 class="text-3xl font-extrabold text-gray-800 mb-6 flex items-center gap-2">
            <span class="text-blue-600">✏️</span> Edit Transaksi
        </h1>

        <form action="{{ route('kasir.reports.update', $report->id) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            {{-- Kasir --}}
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Kasir</label>
                <select name="cashier" required
                    class="w-full border-gray-300 rounded-xl px-3 py-2 shadow-sm focus:ring-2 focus:ring-blue-400 focus:border-blue-400 @error('cashier') border-red-500 @enderror">
                    <option value="">-- Pilih Kasir --</option>
                    @foreach($kasirs as $kasir)
                        <option value="{{ $kasir->name }}" {{ $report->cashier == $kasir->name ? 'selected' : '' }}>
                            {{ $kasir->name }}
                        </option>
                    @endforeach
                </select>
                @error('cashier')
                    <p class="text-red-500 text-sm mt-1">⚠ {{ $message }}</p>
                @enderror
            </div>

            {{-- Customer --}}
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Customer</label>
                <input type="text" name="customer" value="{{ old('customer', $report->customer) }}"
                    class="w-full border-gray-300 rounded-xl px-3 py-2 shadow-sm focus:ring-2 focus:ring-blue-400 focus:border-blue-400 @error('customer') border-red-500 @enderror"
                    placeholder="Nama Customer">
                @error('customer')
                    <p class="text-red-500 text-sm mt-1">⚠ {{ $message }}</p>
                @enderror
            </div>

            {{-- Total & Diskon --}}
            <div class="grid grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Total</label>
                    <input type="number" name="total" value="{{ old('total', $report->total) }}" required
                        class="w-full border-gray-300 rounded-xl px-3 py-2 shadow-sm focus:ring-2 focus:ring-blue-400 focus:border-blue-400 @error('total') border-red-500 @enderror"
                        placeholder="0">
                    @error('total')
                        <p class="text-red-500 text-sm mt-1">⚠ {{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Diskon</label>
                    <input type="number" name="discount" value="{{ old('discount', $report->discount) }}"
                        class="w-full border-gray-300 rounded-xl px-3 py-2 shadow-sm focus:ring-2 focus:ring-blue-400 focus:border-blue-400 @error('discount') border-red-500 @enderror"
                        placeholder="0">
                    @error('discount')
                        <p class="text-red-500 text-sm mt-1">⚠ {{ $message }}</p>
                    @enderror
                </div>
            </div>

            {{-- Bayar & Kembalian --}}
            <div class="grid grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Bayar</label>
                    <input type="number" name="pay" value="{{ old('pay', $report->pay) }}" required
                        class="w-full border-gray-300 rounded-xl px-3 py-2 shadow-sm focus:ring-2 focus:ring-blue-400 focus:border-blue-400 @error('pay') border-red-500 @enderror"
                        placeholder="0">
                    @error('pay')
                        <p class="text-red-500 text-sm mt-1">⚠ {{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Kembalian</label>
                    <input type="number" name="change" value="{{ old('change', $report->change) }}" required
                        class="w-full border-gray-300 rounded-xl px-3 py-2 shadow-sm focus:ring-2 focus:ring-blue-400 focus:border-blue-400 @error('change') border-red-500 @enderror"
                        placeholder="0">
                    @error('change')
                        <p class="text-red-500 text-sm mt-1">⚠ {{ $message }}</p>
                    @enderror
                </div>
            </div>

            {{-- Tombol --}}
            <div class="flex justify-end space-x-4 pt-4">
                <a href="{{ route('kasir.reports.index') }}"
                    class="px-5 py-2.5 rounded-xl bg-gray-200 hover:bg-gray-300 text-gray-700 font-medium shadow">
                    ⬅ Batal
                </a>
                <button type="submit"
                    class="px-5 py-2.5 rounded-xl bg-blue-600 hover:bg-blue-700 text-white font-semibold shadow">
                    💾 Update
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
