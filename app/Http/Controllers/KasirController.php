<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use Illuminate\Support\Facades\Log; // Tambahkan ini


class KasirController extends Controller
{
    /**
     * Tampilkan halaman kasir dengan daftar produk & kategori.
     */
    public function index()
    {
        $products = Product::all();

        $categories = Product::select('category')
            ->whereNotNull('category')
            ->distinct()
            ->pluck('category');

        $totalProducts = Product::count();
        $totalTransactions = Transaction::count();
        $totalUsers = \App\Models\User::count();

        $latestTransactions = Transaction::with('user')
            ->latest()
            ->take(5)
            ->get();

        return view('kasir.index', compact(
            'products',
            'categories',
            'totalProducts',
            'totalTransactions',
            'totalUsers',
            'latestTransactions'
        ));
    }
    /**
     * Ambil data produk berdasarkan barcode.
     */
    public function getProduct($barcode)
    {
        $product = Product::where('barcode', $barcode)->first();
        return response()->json($product);
    }

    /**
     * Simpan transaksi beserta detailnya.
     */
    public function transaksiStore(Request $request)
    {
        try {
            $validated = $request->validate([
                'cashier' => 'required|string|max:100',
                'total'   => 'required|numeric',
                'pay'     => 'required|numeric',
                'change'  => 'required|numeric',
                'items'   => 'required|array|min:1',
                'items.*.product_id' => 'required|exists:products,id',
                'items.*.qty'        => 'required|integer|min:1',
                'items.*.price'      => 'required|numeric|min:0',
                'items.*.subtotal'   => 'required|numeric|min:0',
            ]);

            $transaksi = Transaction::create([
                'customer' => $request->customer,
                'total' => $request->total,
                'discount' => $request->discount,
                'pay' => $request->pay,
                'change' => $request->change,
                'cashier' => auth()->user()->name, // atau 'cashier_id' => auth()->id()
            ]);

            foreach ($request->items as $item) {
                TransactionDetail::create([
                    'transaction_id' => $transaksi->id,
                    'product_id'     => $item['product_id'],
                    'qty'            => $item['qty'],
                    'price'          => $item['price'],
                    'subtotal'       => $item['subtotal'],
                ]);

                Product::find($item['product_id'])->decrement('stock', $item['qty']);
            }

            return response()->json(['success' => true]);
        } catch (\Throwable $e) {
            Log::error('Gagal menyimpan transaksi: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Gagal menyimpan transaksi.',
                'error'   => $e->getMessage()
            ], 500);
        }
    }


    /**
     * Tampilkan daftar produk saja.
     */
    public function listProduk()
    {
        $products = Product::all();
        return view('kasir.products', compact('products'));
    }
}
