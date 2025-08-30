<?php

namespace App\Http\Controllers\Kasir;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Transaction;
use App\Models\User;

class KasirLaporanController extends Controller
{
    public function index(Request $request)
    {
        $bulan = $request->input('bulan', date('m'));
        $tahun = $request->input('tahun', date('Y'));

        $laporan = Transaction::whereMonth('created_at', $bulan)
            ->whereYear('created_at', $tahun)
            ->get();

        $totalPendapatan = $laporan->sum('total');
        $totalDiskon = $laporan->sum('discount');
        $totalBayar = $laporan->sum('pay');

        return view('kasir.laporan.index', compact(
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
    $kasirs = User::where('role', 'kasir')->get();
    return view('kasir.laporan.create', compact('kasirs'));
}

    public function store(Request $request)
    {
        $request->validate([
            'cashier' => 'required|string|max:255',
            'customer' => 'nullable|string|max:255',
            'total' => 'required|numeric',
            'discount' => 'nullable|numeric',
            'pay' => 'required|numeric',
            'change' => 'required|numeric',
        ]);

        Transaction::create($request->all());

        return redirect()->route('kasir.reports.index')->with('success', 'Transaksi berhasil ditambahkan');
    }

    public function show(Transaction $report) // ubah: $laporan => $report
    {
        return view('kasir.laporan.show', compact('report'));
    }

public function edit($id)
{
    $report = Transaction::findOrFail($id);   // ✅ pakai Transaction
    $kasirs = User::where('role', 'kasir')->get();

    return view('kasir.laporan.edit', compact('report', 'kasirs'));
}


    public function update(Request $request, Transaction $report)
    {
        $request->validate([
            'cashier' => 'required|string|max:255',
            'customer' => 'nullable|string|max:255',
            'total' => 'required|numeric',
            'discount' => 'nullable|numeric',
            'pay' => 'required|numeric',
            'change' => 'required|numeric',
        ]);

        $report->update($request->all());

        return redirect()->route('kasir.reports.index')->with('success', 'Transaksi berhasil diperbarui');
    }

    public function destroy(Transaction $report)
    {
        $report->delete();
        return redirect()->route('kasir.reports.index')->with('success', 'Transaksi berhasil dihapus');
    }
}
