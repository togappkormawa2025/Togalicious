@extends('layouts.app')

@section('content')
<div class="p-6 bg-gray-50 min-h-screen">
  <div class="max-w-lg mx-auto bg-white p-8 rounded-2xl shadow-md border border-gray-100">
    <h1 class="text-2xl font-bold text-asparagus mb-6 flex items-center gap-2">
      <i class="fa-solid fa-box"></i> Tambah Produk
    </h1>

    <form action="{{ route('kasir.produk.store') }}" method="POST" enctype="multipart/form-data" class="space-y-5">
      @csrf

      <!-- Nama Produk -->
      <div>
        <label class="block font-medium text-gray-700 mb-1">Nama Produk</label>
        <input type="text" name="name" value="{{ old('name') }}" required
               class="w-full border-gray-300 rounded-lg p-3 focus:ring-2 focus:ring-asparagus focus:border-asparagus placeholder-gray-400">
      </div>

      <!-- Kategori -->
      <div>
        <label class="block font-medium text-gray-700 mb-1">Kategori Produk</label>
        <select name="category" required
                class="w-full border-gray-300 rounded-lg p-3 focus:ring-2 focus:ring-asparagus focus:border-asparagus">
          <option value="">-- Pilih Kategori --</option>
          @foreach($categories as $cat)
            <option value="{{ $cat }}" {{ old('category') == $cat ? 'selected' : '' }}>{{ $cat }}</option>
          @endforeach
        </select>
      </div>

      <!-- Harga -->
      <div>
        <label class="block font-medium text-gray-700 mb-1">Harga</label>
        <input type="number" name="price" value="{{ old('price') }}" required
               class="w-full border-gray-300 rounded-lg p-3 focus:ring-2 focus:ring-asparagus focus:border-asparagus">
        <p class="text-xs text-gray-500 mt-1">Masukkan harga dalam rupiah</p>
      </div>

      <!-- Stok -->
      <div>
        <label class="block font-medium text-gray-700 mb-1">Stok</label>
        <input type="number" name="stock" value="{{ old('stock') }}" required
               class="w-full border-gray-300 rounded-lg p-3 focus:ring-2 focus:ring-asparagus focus:border-asparagus">
      </div>

      <!-- Foto -->
      <div>
        <label class="block font-medium text-gray-700 mb-1">Foto Produk <span class="text-gray-400 text-sm">(opsional)</span></label>
        <input type="file" name="photo" accept="image/*"
               class="w-full border-gray-300 rounded-lg p-2 focus:ring-2 focus:ring-asparagus focus:border-asparagus file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-asparagus file:text-white hover:file:bg-asparagus-dark">
      </div>

      <!-- Tombol -->
      <div class="flex items-center gap-3 pt-2">
        <button class="bg-asparagus hover:bg-asparagus-dark text-white px-5 py-2.5 rounded-lg shadow-md transition">
          <i class="fa-solid fa-check mr-1"></i> Simpan
        </button>
        <a href="{{ route('kasir.produk.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-5 py-2.5 rounded-lg shadow-md transition">
          <i class="fa-solid fa-arrow-left mr-1"></i> Kembali
        </a>
      </div>
    </form>
  </div>
</div>
@endsection
