@extends('layouts.admin')

@section('content')
<div class="p-6">
  <h2 class="text-2xl font-bold text-asparagus mb-6">Manajemen Produk</h2>

  <div class="mb-4">
    <a href="{{ route('admin.produk.create') }}"
       class="inline-block bg-green-600 text-white px-4 py-2 rounded-lg shadow hover:bg-green-700 transition">
      + Tambah Produk
    </a>
  </div>

  <div class="bg-white rounded-xl shadow-lg overflow-hidden">
    <table class="min-w-full text-sm text-left border-collapse">
      <thead class="bg-asparagus text-white">
        <tr>
          <th class="p-3 font-semibold">No</th>
          <th class="p-3 font-semibold">Nama</th>
          <th class="p-3 font-semibold">Kategori</th>
          <th class="p-3 font-semibold text-right">Harga</th>
          <th class="p-3 font-semibold text-right">Stok</th>
          <th class="p-3 font-semibold text-center">Aksi</th>
        </tr>
      </thead>
      <tbody>
        @forelse($products as $product)
        <tr class="border-b hover:bg-gray-50">
          <td class="p-3">{{ $loop->iteration }}</td>
          <td class="p-3 font-medium text-gray-800">{{ $product->name }}</td>
          <td class="p-3 text-gray-600">{{ $product->category }}</td>
          <td class="p-3 text-right text-gray-800">Rp {{ number_format($product->price, 0, ',', '.') }}</td>
          <td class="p-3 text-right text-gray-800">{{ $product->stock }}</td>
          <td class="p-3 text-center space-x-2">
            <a href="{{ route('admin.produk.edit', $product->id) }}"
               class="inline-block px-3 py-1 text-xs font-semibold text-blue-600 bg-blue-50 rounded-lg hover:bg-blue-100 transition">
              Edit
            </a>
            <form action="{{ route('admin.produk.destroy', $product->id) }}" method="POST" class="inline"
              onsubmit="return confirm('Yakin ingin menghapus produk ini?')">
              @csrf @method('DELETE')
              <button type="submit"
                class="inline-block px-3 py-1 text-xs font-semibold text-red-600 bg-red-50 rounded-lg hover:bg-red-100 transition">
                Hapus
              </button>
            </form>
          </td>
        </tr>
        @empty
        <tr>
          <td colspan="6" class="text-center text-gray-500 p-6">Tidak ada produk.</td>
        </tr>
        @endforelse
      </tbody>
    </table>
  </div>
</div>
@endsection
