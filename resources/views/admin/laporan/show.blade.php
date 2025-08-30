@extends('layouts.admin')

@section('content')
<div class="p-6 space-y-6">
    <h1 class="text-2xl font-bold text-gray-800">📄 Detail Laporan</h1>

    <div class="bg-white p-6 rounded-xl shadow-md border border-gray-200">
        <p><span class="font-semibold">Bulan:</span> {{ $laporan->bulan }}</p>
        <p><span class="font-semibold">Tahun:</span> {{ $laporan->tahun }}</p>
        <p><span class="font-semibold">Keterangan:</span> {{ $laporan->keterangan }}</p>
        <p><span class="font-semibold">Dibuat:</span> {{ $laporan->created_at->format('d M Y H:i') }}</p>

        <div class="flex justify-end mt-4 gap-2">
            <a href="{{ route('admin.reports.index') }}"
               class="px-5 py-2 rounded-lg border border-gray-300 text-gray-700 hover:bg-gray-100">
                ⬅️ Kembali
            </a>
            <a href="{{ route('admin.reports.edit', $laporan->id) }}"
               class="px-5 py-2 bg-yellow-500 hover:bg-yellow-600 text-white rounded-lg">
                ✏️ Edit
            </a>
        </div>
    </div>
</div>
@endsection
