@extends('layouts.admin')

@section('content')
<div class="p-6">
  <div class="max-w-2xl mx-auto bg-white shadow-lg rounded-xl p-6">
    <h2 class="text-2xl font-bold mb-6 text-gray-800 border-b pb-3">Tambah Produk</h2>

    <form action="{{ route('admin.produk.store') }}" method="POST" class="space-y-5">
      @csrf

      <div>
        <label class="block font-semibold text-gray-700 mb-2">Nama Produk</label>
        <input type="text" name="name"
               class="w-full border-gray-300 rounded-lg shadow-sm p-3 focus:ring-2 focus:ring-green-500 focus:border-green-500"
               required>
      </div>

      <div>
        <label class="block font-semibold text-gray-700 mb-2">Kategori</label>
        <input type="text" name="category"
               class="w-full border-gray-300 rounded-lg shadow-sm p-3 focus:ring-2 focus:ring-green-500 focus:border-green-500">
      </div>

      <div>
        <label class="block font-semibold text-gray-700 mb-2">Harga</label>
        <input type="number" name="price"
               class="w-full border-gray-300 rounded-lg shadow-sm p-3 focus:ring-2 focus:ring-green-500 focus:border-green-500"
               required>
      </div>

      <div>
        <label class="block font-semibold text-gray-700 mb-2">Stok</label>
        <input type="number" name="stock"
               class="w-full border-gray-300 rounded-lg shadow-sm p-3 focus:ring-2 focus:ring-green-500 focus:border-green-500"
               required>
      </div>

      <div class="flex items-center justify-between pt-4">
        <button type="submit"
                class="bg-green-600 text-white px-5 py-2 rounded-lg shadow hover:bg-green-700 transition">
          Simpan
        </button>
        <a href="{{ route('admin.produk.index') }}"
           class="text-gray-600 hover:text-gray-800 hover:underline">
          Batal
        </a>
      </div>
    </form>
  </div>
</div>
@endsection
