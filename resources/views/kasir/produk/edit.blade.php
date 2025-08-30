@extends('layouts.app')

@section('content')
<div class="p-6 bg-gray-50 min-h-screen">
  <div class="max-w-lg mx-auto bg-white p-8 rounded-2xl shadow-md border border-gray-100">
    <h1 class="text-2xl font-bold text-yellow-600 mb-6 flex items-center gap-2">
      <i class="fa-solid fa-pen-to-square"></i> Edit Produk
    </h1>

    <form action="{{ route('kasir.produk.update', $product->id) }}" method="POST" enctype="multipart/form-data" class="space-y-5">
      @csrf
      @method('PUT')

      <!-- Nama Produk -->
      <div>
        <label class="block font-medium text-gray-700 mb-1">Nama Produk</label>
        <input type="text" name="name" value="{{ old('name', $product->name) }}" required
               class="w-full border-gray-300 rounded-lg p-3 focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500 placeholder-gray-400">
      </div>

      <!-- Kategori -->
      <div>
        <label class="block font-medium text-gray-700 mb-1">Kategori Produk</label>
        <select name="category" required
                class="w-full border-gray-300 rounded-lg p-3 focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500">
          <option value="">-- Pilih Kategori --</option>
          @foreach($categories as $cat)
            <option value="{{ $cat }}" {{ old('category', $product->category) == $cat ? 'selected' : '' }}>
              {{ $cat }}
            </option>
          @endforeach
        </select>
      </div>

      <!-- Harga -->
      <div>
        <label class="block font-medium text-gray-700 mb-1">Harga</label>
        <input type="number" name="price" value="{{ old('price', $product->price) }}" required
               class="w-full border-gray-300 rounded-lg p-3 focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500">
      </div>

      <!-- Stok -->
      <div>
        <label class="block font-medium text-gray-700 mb-1">Stok</label>
        <input type="number" name="stock" value="{{ old('stock', $product->stock) }}" required
               class="w-full border-gray-300 rounded-lg p-3 focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500">
      </div>

      <!-- Foto Produk -->
      <div>
        <label class="block font-medium text-gray-700 mb-1">Foto Produk</label>
        @if($product->photo)
          <div class="mb-3">
            <img src="{{ asset('storage/' . $product->photo) }}"
                 class="w-28 h-28 object-cover rounded-lg border border-gray-200 shadow-sm"
                 alt="Foto Produk">
          </div>
        @endif
        <input type="file" name="photo" accept="image/*"
               class="w-full border-gray-300 rounded-lg p-2 focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-yellow-500 file:text-white hover:file:bg-yellow-600">
      </div>

      <!-- Tombol -->
      <div class="flex items-center gap-3 pt-2">
        <button class="bg-yellow-500 hover:bg-yellow-600 text-white px-5 py-2.5 rounded-lg shadow-md transition">
          <i class="fa-solid fa-rotate mr-1"></i> Update
        </button>
        <a href="{{ route('kasir.produk.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-5 py-2.5 rounded-lg shadow-md transition">
          <i class="fa-solid fa-arrow-left mr-1"></i> Kembali
        </a>
      </div>
    </form>
  </div>
</div>
@endsection
