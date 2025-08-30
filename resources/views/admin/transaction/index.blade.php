@extends('layouts.admin')

@section('content')
<div class="p-4 sm:p-6">
    <h1 class="text-xl sm:text-2xl font-semibold mb-4">Riwayat Transaksi</h1>

    <!-- Tombol Tambah -->
    <div class="mb-4">
        <a href="{{ route('admin.transactions.create') }}"
           class="inline-block px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 text-sm sm:text-base">
            ➕ Tambah Transaksi
        </a>
    </div>

    <!-- Table Wrapper -->
    <div class="bg-white rounded-lg shadow overflow-x-auto">
        <table class="min-w-full table-auto border-collapse text-xs sm:text-sm">
            <thead class="bg-gray-100 text-gray-700 uppercase">
                <tr>
                    <th class="px-4 sm:px-6 py-3 text-left">No</th>
                    <th class="px-4 sm:px-6 py-3 text-left">Tanggal</th>
                    <th class="px-4 sm:px-6 py-3 text-left">Total</th>
                    <th class="px-4 sm:px-6 py-3 text-left">User</th>
                    <th class="px-4 sm:px-6 py-3 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse ($transactions as $transaction)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-4 sm:px-6 py-3">{{ $loop->iteration }}</td>
                        <td class="px-4 sm:px-6 py-3 whitespace-nowrap">
                            {{ $transaction->created_at->format('d M Y H:i') }}
                        </td>
                        <td class="px-4 sm:px-6 py-3 font-medium text-green-600 whitespace-nowrap">
                            Rp {{ number_format($transaction->total, 0, ',', '.') }}
                        </td>
                        <td class="px-4 sm:px-6 py-3">{{ $transaction->cashier ?? '-' }}</td>
                        <td class="px-4 sm:px-6 py-3">
                            <div class="flex flex-col sm:flex-row sm:justify-center gap-2">
                                <!-- Detail -->
                                <a href="{{ route('admin.transactions.show', $transaction->id) }}"
                                   class="px-3 py-1 bg-blue-500 text-white rounded hover:bg-blue-600 text-xs sm:text-sm text-center">
                                    Detail
                                </a>

                                <!-- Edit -->
                                <a href="{{ route('admin.transactions.edit', $transaction->id) }}"
                                   class="px-3 py-1 bg-yellow-500 text-white rounded hover:bg-yellow-600 text-xs sm:text-sm text-center">
                                    Edit
                                </a>

                                <!-- Hapus -->
                                <form action="{{ route('admin.transactions.destroy', $transaction->id) }}"
                                      method="POST" class="inline"
                                      onsubmit="return confirm('Yakin ingin menghapus transaksi ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            class="px-3 py-1 bg-red-500 text-white rounded hover:bg-red-600 text-xs sm:text-sm w-full sm:w-auto">
                                        Hapus
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center py-6 text-gray-500 text-sm">Tidak ada transaksi</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="mt-6">
        {{ $transactions->links() }}
    </div>
</div>
@endsection
