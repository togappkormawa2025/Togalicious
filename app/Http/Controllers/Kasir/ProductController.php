<?php

namespace App\Http\Controllers\Kasir;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::all();
        return view('kasir.produk.index', compact('products'));
    }

    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'photo' => 'nullable|file', // foto bebas ukuran & format
            'category' => 'nullable|string',
        ]);

        if ($request->hasFile('photo')) {
            // Hapus foto lama kalau ada
            if ($product->photo && Storage::disk('public')->exists($product->photo)) {
                Storage::disk('public')->delete($product->photo);
            }
            // Simpan foto baru
            $validated['photo'] = $request->file('photo')->store('produk', 'public');
        }

        $product->update($validated);

        return redirect()->route('kasir.produk.index')->with('success', 'Produk berhasil diperbarui.');
    }

    public function destroy(Product $product)
    {
        if ($product->photo && Storage::disk('public')->exists($product->photo)) {
            Storage::disk('public')->delete($product->photo);
        }
        $product->delete();
        return redirect()->route('kasir.produk.index')->with('success', 'Produk berhasil dihapus.');
    }

    public function kasirProduk(Request $request)
    {
        $query = Product::query();

        if ($request->has('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        if ($request->has('category')) {
            $query->where('category', $request->category);
        }

        $products = $query->select('id', 'name', 'price', 'stock', 'photo', 'category')->get();

        return response()->json($products);
    }

    public function create()
    {
        $categories = ['Makanan', 'Minuman', 'Rimpang', 'Lainnya'];
        return view('kasir.produk.create', compact('categories'));
    }

    public function edit(Product $product)
    {
        $categories = ['Makanan', 'Minuman', 'Lainnya'];
        return view('kasir.produk.edit', compact('product', 'categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'photo' => 'nullable|file', // foto bebas ukuran & format
            'category' => 'nullable|string',
        ]);

        if ($request->hasFile('photo')) {
            $validated['photo'] = $request->file('photo')->store('produk', 'public');
        }

        Product::create($validated);

        return redirect()->route('kasir.produk.index')->with('success', 'Produk berhasil ditambahkan.');
    }
}
