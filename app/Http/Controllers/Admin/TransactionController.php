<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function index()
    {
        $transactions = Transaction::with('user')->latest()->paginate(10);
        return view('admin.transaction.index', compact('transactions'));
    }

    public function show(Transaction $transaction)
    {
        $transaction->load('details.product', 'user'); // relasi detail & user
        return view('admin.transaction.show', compact('transaction'));
    }

    public function create()
    {
        $kasirs = User::where('role', 'kasir')->get();
        return view('admin.transaction.create', compact('kasirs'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id'   => 'required|exists:users,id',
            'customer'  => 'nullable|string|max:255',
            'total'     => 'required|numeric',
            'discount'  => 'nullable|numeric',
            'pay'       => 'required|numeric',
            'change'    => 'required|numeric',
        ]);

        Transaction::create($request->all());
        return redirect()->route('admin.transactions.index')->with('success', 'Transaksi berhasil ditambahkan');
    }

    public function edit(Transaction $transaction)
    {
        $kasirs = User::where('role', 'kasir')->get();
        return view('admin.transaction.edit', compact('transaction', 'kasirs'));
    }

    public function update(Request $request, Transaction $transaction)
    {
        $request->validate([
            'user_id'   => 'required|exists:users,id',
            'customer'  => 'nullable|string|max:255',
            'total'     => 'required|numeric',
            'discount'  => 'nullable|numeric',
            'pay'       => 'required|numeric',
            'change'    => 'required|numeric',
        ]);

        $transaction->update($request->all());
        return redirect()->route('admin.transactions.index')->with('success', 'Transaksi berhasil diperbarui');
    }

    public function destroy(Transaction $transaction)
    {
        $transaction->delete();
        return redirect()->route('admin.transactions.index')->with('success', 'Transaksi berhasil dihapus');
    }
}
