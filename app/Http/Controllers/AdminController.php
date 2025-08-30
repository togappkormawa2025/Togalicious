<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    /**
     * Tampilkan dashboard admin dengan statistik & grafik.
     */


public function index()
{
    $totalProducts     = Product::count();
    $totalTransactions = Transaction::count();
    $totalUsers        = User::count();
    $latestTransactions = Transaction::latest()->take(5)->get();
    $produk = Product::latest()->get();

    // Ambil data untuk grafik: jumlah produk per kategori
    $kategoriData = Product::select('category', DB::raw('count(*) as total'))
                    ->groupBy('category')
                    ->pluck('total', 'category');

    // Ambil data untuk grafik user per role
    $userData = User::select('role', DB::raw('count(*) as total'))
                ->groupBy('role')
                ->pluck('total', 'role');

    // Kirim ke view sebagai labels dan data
    return view('admin.index', [
        'totalProducts' => $totalProducts,
        'totalTransactions' => $totalTransactions,
        'totalUsers' => $totalUsers,
        'latestTransactions' => $latestTransactions,
        'produk' => $produk,

        // Data untuk ChartJS
        'labels' => $kategoriData->keys(),
        'data' => $kategoriData->values(),

        'userLabels' => $userData->keys(),
        'userData' => $userData->values(),
    ]);
}

 public function statistics()
    {
        // Contoh data statistik:
$penjualanPerHari = Transaction::selectRaw('DATE(created_at) as tanggal, SUM(total) as total')
    ->groupBy('tanggal')
    ->orderBy('tanggal', 'desc')
    ->take(7)
    ->get();


        $produkTerlaris = TransactionDetail::selectRaw('product_id, SUM(quantity) as total_terjual')
            ->groupBy('product_id')
            ->orderByDesc('total_terjual')
            ->with('product')
            ->take(5)
            ->get();

        return view('admin.statistics.index', compact('penjualanPerHari', 'produkTerlaris'));
    }

    /**
     * Halaman manajemen produk (admin).
     */
    public function manajemenProduk()
    {
        $produk = Product::all();
        return view('admin.produk.index', compact('produk'));
    }
}
