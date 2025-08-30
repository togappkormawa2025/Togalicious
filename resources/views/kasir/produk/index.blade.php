@extends('layouts.app')

@section('content')
<div class="p-6 space-y-6">
  <!-- Header -->
  <div class="flex justify-between items-center">
    <h2 class="text-2xl font-bold text-asparagus flex items-center gap-2">
      <i class="fa-solid fa-box"></i> Daftar Produk
    </h2>
    <a href="{{ route('kasir.produk.create') }}"
       class="inline-flex items-center gap-2 bg-asparagus text-white hover:bg-asparagus-dark px-4 py-2 rounded-lg shadow-md text-sm transition">
      <i class="fa-solid fa-plus"></i> Tambah Produk
    </a>
  </div>

  <!-- Flash Message -->
  @if(session('success'))
    <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg shadow-sm flex items-center gap-2">
      <i class="fa-solid fa-circle-check"></i>
      <span>{{ session('success') }}</span>
    </div>
  @endif

  <!-- Produk Table -->
  <div class="bg-white rounded-xl shadow border border-gray-100 overflow-hidden">
    <table class="min-w-full table-auto">
      <thead class="bg-gray-50 text-xs font-semibold text-gray-600 uppercase tracking-wider">
        <tr>
          <th class="px-4 py-3 text-center border-b">No</th>
          <th class="px-4 py-3 text-center border-b">Foto</th>
          <th class="px-4 py-3 text-left border-b">Nama Produk</th>
          <th class="px-4 py-3 text-left border-b">Harga</th>
          <th class="px-4 py-3 text-left border-b">Stok</th>
          <th class="px-4 py-3 text-center border-b">Aksi</th>
        </tr>
      </thead>

      @php
        $no = ($products instanceof \Illuminate\Pagination\LengthAwarePaginator)
              ? $products->firstItem()
              : 1;
      @endphp

      <tbody class="text-sm text-gray-700 divide-y divide-gray-100">
        @forelse($products as $product)
        <tr class="hover:bg-gray-50 transition">
          <td class="px-4 py-3 text-center">{{ $no++ }}</td>
          <td class="px-4 py-3 text-center">
            @if($product->photo)
              <img src="{{ asset('storage/'.$product->photo) }}"
                   class="w-14 h-14 object-cover rounded-lg mx-auto border border-gray-200 shadow-sm"
                   alt="foto produk">
            @else
              <span class="text-gray-400 italic">Tidak ada</span>
            @endif
          </td>
          <td class="px-4 py-3 font-medium">{{ $product->name }}</td>
          <td class="px-4 py-3">Rp {{ number_format($product->price, 0, ',', '.') }}</td>
          <td class="px-4 py-3">{{ $product->stock }}</td>
          <td class="px-4 py-3 text-center">
            <div class="flex justify-center items-center gap-2">
              <a href="{{ route('kasir.produk.edit', $product) }}"
                 class="bg-yellow-400 hover:bg-yellow-500 text-white px-3 py-1.5 rounded-md text-xs shadow-sm transition flex items-center gap-1"
                 title="Edit">
                <i class="fa-solid fa-pen"></i> Edit
              </a>
              <form action="{{ route('kasir.produk.destroy', $product) }}" method="POST"
                    onsubmit="return confirm('Yakin ingin menghapus produk ini?')" class="inline">
                @csrf
                @method('DELETE')
                <button type="submit"
                        class="bg-red-600 hover:bg-red-700 text-white px-3 py-1.5 rounded-md text-xs shadow-sm transition flex items-center gap-1"
                        title="Hapus">
                  <i class="fa-solid fa-trash"></i> Hapus
                </button>
              </form>
            </div>
          </td>
        </tr>
        @empty
        <tr>
          <td colspan="6" class="text-center text-gray-500 italic px-4 py-8">
            Belum ada produk yang tersedia.
          </td>
        </tr>
        @endforelse
      </tbody>
    </table>
  </div>

  <!-- Pagination -->
  @if($products instanceof \Illuminate\Pagination\LengthAwarePaginator)
    <div class="mt-4">
      {{ $products->links() }}
    </div>
  @endif
</div>
@endsection
