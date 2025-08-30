@extends('layouts.admin')

@section('content')
<div class="p-4 sm:p-6 max-w-4xl mx-auto">
    <h2 class="text-xl sm:text-2xl font-bold text-asparagus mb-6">✏️ Edit Transaksi</h2>

    <form action="{{ route('admin.transactions.update', $transaction->id) }}" method="POST"
          class="bg-white p-4 sm:p-6 rounded-lg shadow space-y-5">
        @csrf
        @method('PUT')

        {{-- Kasir --}}
        <div>
            <label class="block text-sm font-medium text-gray-700">Kasir</label>
            <select name="cashier"
                    class="w-full border rounded-lg px-3 py-2 mt-1 text-sm sm:text-base focus:ring focus:ring-blue-200">
                <option value="">-- Pilih Kasir --</option>
                @foreach($kasirs as $kasir)
                    <option value="{{ $kasir->id }}" {{ $transaction->cashier == $kasir->id ? 'selected' : '' }}>
                        {{ $kasir->name }}
                    </option>
                @endforeach
            </select>
            @error('cashier') <p class="text-red-500 text-xs sm:text-sm mt-1">{{ $message }}</p> @enderror
        </div>

        {{-- Customer --}}
        <div>
            <label class="block text-sm font-medium text-gray-700">Customer</label>
            <input type="text" name="customer"
                   value="{{ old('customer', $transaction->customer) }}"
                   class="w-full border rounded-lg px-3 py-2 mt-1 text-sm sm:text-base focus:ring focus:ring-blue-200">
            @error('customer') <p class="text-red-500 text-xs sm:text-sm mt-1">{{ $message }}</p> @enderror
        </div>

        {{-- Total & Diskon --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700">Total</label>
                <input type="number" name="total"
                       value="{{ old('total', $transaction->total) }}"
                       class="w-full border rounded-lg px-3 py-2 mt-1 text-sm sm:text-base focus:ring focus:ring-blue-200">
                @error('total') <p class="text-red-500 text-xs sm:text-sm mt-1">{{ $message }}</p> @enderror
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Diskon</label>
                <input type="number" name="discount"
                       value="{{ old('discount', $transaction->discount) }}"
                       class="w-full border rounded-lg px-3 py-2 mt-1 text-sm sm:text-base focus:ring focus:ring-blue-200">
                @error('discount') <p class="text-red-500 text-xs sm:text-sm mt-1">{{ $message }}</p> @enderror
            </div>
        </div>

        {{-- Bayar & Kembalian --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700">Bayar</label>
                <input type="number" name="pay"
                       value="{{ old('pay', $transaction->pay) }}"
                       class="w-full border rounded-lg px-3 py-2 mt-1 text-sm sm:text-base focus:ring focus:ring-blue-200">
                @error('pay') <p class="text-red-500 text-xs sm:text-sm mt-1">{{ $message }}</p> @enderror
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Kembalian</label>
                <input type="number" name="change"
                       value="{{ old('change', $transaction->change) }}"
                       class="w-full border rounded-lg px-3 py-2 mt-1 text-sm sm:text-base focus:ring focus:ring-blue-200">
                @error('change') <p class="text-red-500 text-xs sm:text-sm mt-1">{{ $message }}</p> @enderror
            </div>
        </div>

        {{-- Tombol Aksi --}}
        <div class="flex flex-col sm:flex-row justify-end gap-3">
            <a href="{{ route('admin.transactions.index') }}"
               class="px-4 py-2 rounded-lg bg-gray-300 hover:bg-gray-400 text-gray-800 text-center">
                ⬅ Batal
            </a>
            <button type="submit"
                    class="px-4 py-2 rounded-lg bg-blue-600 hover:bg-blue-700 text-white">
                💾 Update
            </button>
        </div>
    </form>
</div>
@endsection
