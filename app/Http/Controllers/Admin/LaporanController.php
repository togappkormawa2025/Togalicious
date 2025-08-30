<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Transaction;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        // Filter bulan dan tahun
        $bulan = $request->input('bulan', date('m'));
        $tahun = $request->input('tahun', date('Y'));

        $laporan = Transaction::whereMonth('created_at', $bulan)
            ->whereYear('created_at', $tahun)
            ->latest()
            ->get();

        // Perhitungan total keuangan
        $totalPendapatan = $laporan->sum('total');
        $totalDiskon = $laporan->sum('discount');
        $totalBayar = $laporan->sum('pay');

        return view('admin.laporan.index', compact(
            'laporan',
            'totalPendapatan',
            'totalDiskon',
            'totalBayar',
            'bulan',
            'tahun'
        ));
    }

    public function create()
    {
        return view('admin.laporan.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'cashier'   => 'required|string|max:100',
            'customer'  => 'nullable|string|max:100',
            'total'     => 'required|numeric',
            'discount'  => 'required|numeric',
            'pay'       => 'required|numeric',
            'change'    => 'required|numeric',
        ]);

        Transaction::create($validated);

        return redirect()->route('admin.laporan.index')->with('success', 'Laporan berhasil ditambahkan.');
    }

    public function show(Transaction $laporan)
    {
        return view('admin.laporan.show', compact('laporan'));
    }

    public function edit(Transaction $laporan)
    {
        return view('admin.laporan.edit', compact('laporan'));
    }

    public function update(Request $request, Transaction $laporan)
    {
        $validated = $request->validate([
            'cashier'   => 'required|string|max:100',
            'customer'  => 'nullable|string|max:100',
            'total'     => 'required|numeric',
            'discount'  => 'required|numeric',
            'pay'       => 'required|numeric',
            'change'    => 'required|numeric',
        ]);

        $laporan->update($validated);

        return redirect()->route('admin.laporan.index')->with('success', 'Laporan berhasil diperbarui.');
    }

    public function destroy(Transaction $laporan)
    {
        $laporan->delete();
        return redirect()->route('admin.laporan.index')->with('success', 'Laporan berhasil dihapus.');
    }
}
