<?php

namespace App\Exports;

use App\Models\Transaction;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class LaporanKeuanganExport implements FromView
{
    protected $bulan, $tahun;

    public function __construct($bulan, $tahun)
    {
        $this->bulan = $bulan;
        $this->tahun = $tahun;
    }

    public function view(): View
    {
        $laporan = Transaction::whereMonth('created_at', $this->bulan)
            ->whereYear('created_at', $this->tahun)
            ->get();

        $totalPendapatan = $laporan->sum('total');
        $totalDiskon = $laporan->sum('discount');
        $totalBayar = $laporan->sum('pay');

        return view('exports.laporan', [
            'laporan' => $laporan,
            'totalPendapatan' => $totalPendapatan,
            'totalDiskon' => $totalDiskon,
            'totalBayar' => $totalBayar
        ]);
    }
}
