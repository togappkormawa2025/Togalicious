@extends('layouts.admin')

@section('content')
<div class="p-6 max-w-2xl mx-auto">
  <h2 class="text-2xl font-bold mb-6 text-gray-800 border-b pb-2">Edit Produk</h2>

  <form action="{{ route('admin.produk.update', $product->id) }}" method="POST" class="space-y-5 bg-white p-6 rounded-xl shadow">
    @csrf
    @method('PUT')

    <div>
      <label class="block text-gray-700 font-semibold mb-2">Nama Produk</label>
      <input type="text" name="name" value="{{ $product->name }}"
        class="w-full border border-gray-300 rounded-lg p-3 focus:ring-2 focus:ring-blue-500 focus:outline-none" required>
    </div>

    <div>
      <label class="block text-gray-700 font-semibold mb-2">Kategori</label>
      <input type="text" name="category" value="{{ $product->category }}"
        class="w-full border border-gray-300 rounded-lg p-3 focus:ring-2 focus:ring-blue-500 focus:outline-none">
    </div>

    <div>
      <label class="block text-gray-700 font-semibold mb-2">Harga</label>
      <input type="number" name="price" value="{{ $product->price }}"
        class="w-full border border-gray-300 rounded-lg p-3 focus:ring-2 focus:ring-blue-500 focus:outline-none" required>
    </div>

    <div>
      <label class="block text-gray-700 font-semibold mb-2">Stok</label>
      <input type="number" name="stock" value="{{ $product->stock }}"
        class="w-full border border-gray-300 rounded-lg p-3 focus:ring-2 focus:ring-blue-500 focus:outline-none" required>
    </div>

    <div class="flex items-center space-x-4 pt-4">
      <button type="submit"
        class="bg-blue-600 text-white px-5 py-2.5 rounded-lg hover:bg-blue-700 transition">
        Update
      </button>
      <a href="{{ route('admin.produk.index') }}"
        class="text-gray-600 hover:text-gray-900 underline">
        Batal
      </a>
    </div>
  </form>
</div>
@endsection
