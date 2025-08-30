@extends('layouts.admin')

@section('content')
<div class="p-6 space-y-6">
    <h1 class="text-2xl font-bold text-gray-800">✏️ Edit Laporan</h1>

    <div class="bg-white p-6 rounded-xl shadow-md border border-gray-200">
        <form method="POST" action="{{ route('admin.reports.update', $laporan) }}">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label for="bulan" class="block text-sm font-medium text-gray-600">Bulan</label>
                <input type="number" name="bulan" id="bulan" min="1" max="12"
                       value="{{ $laporan->bulan }}"
                       class="mt-1 border-gray-300 rounded-lg px-3 py-2 w-32"
                       required>
            </div>

            <div class="mb-4">
                <label for="tahun" class="block text-sm font-medium text-gray-600">Tahun</label>
                <input type="number" name="tahun" id="tahun"
                       value="{{ $laporan->tahun }}"
                       class="mt-1 border-gray-300 rounded-lg px-3 py-2 w-32"
                       required>
            </div>

            <div class="mb-4">
                <label for="keterangan" class="block text-sm font-medium text-gray-600">Keterangan</label>
                <textarea name="keterangan" id="keterangan" rows="3"
                          class="mt-1 border-gray-300 rounded-lg px-3 py-2 w-full">{{ $laporan->keterangan }}</textarea>
            </div>

            <div class="flex justify-end gap-2">
                <a href="{{ route('admin.reports.index') }}"
                   class="px-5 py-2 rounded-lg border border-gray-300 text-gray-700 hover:bg-gray-100">
                    Batal
                </a>
                <button type="submit"
                        class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg shadow">
                    💾 Update
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
