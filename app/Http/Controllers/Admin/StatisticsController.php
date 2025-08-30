<?php

// app/Http/Controllers/Admin/StatisticsController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Models\Product;
use App\Models\Transaction;
use App\Models\TransactionDetail;

class StatisticsController extends Controller
{
    public function index()
    {
        // Produk terlaris (top 5 berdasarkan jumlah terjual)
        $topProducts = TransactionDetail::select('product_id', DB::raw('SUM(quantity) as total_sold'))
            ->groupBy('product_id')
            ->orderByDesc('total_sold')
            ->take(5)
            ->with('product')
            ->get()
            ->map(function ($item) {
                return (object)[
                    'name' => $item->product->name ?? 'Unknown',
                    'total_sold' => $item->total_sold
                ];
            });

        // Total pendapatan dan diskon
        $totalRevenue = Transaction::sum('total');
        $totalDiscount = Transaction::sum('discount');

        return view('admin.statistics.index', compact('topProducts', 'totalRevenue', 'totalDiscount'));
    }
}
