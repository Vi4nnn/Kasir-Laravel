<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaksi;

class TransaksiController extends Controller
{
    public function index()
    {
        $transactions = Transaksi::all();
        $title = 'Transaction List';

        return view('transaksi.index', compact('transactions', 'title'));
    }

    public function store(Request $request)
    {
        // Validate input data
        $validatedData = $request->validate([
            'no_transaksi' => 'required|string',
            'tgl_transaksi' => 'nullable|date',
            'diskon' => 'nullable|integer',
            'total_bayar' => 'nullable|integer',
        ]);

        Transaksi::create($validatedData);

        return redirect()->route('transaksi.index')->with('success', 'Transaction created successfully.');
    }

    public function update(Request $request, $id)
    {
        // Validate input data
        $validatedData = $request->validate([
            'no_transaksi' => 'required|string',
            'tgl_transaksi' => 'nullable|date',
            'diskon' => 'nullable|integer',
            'total_bayar' => 'nullable|integer',
        ]);

        $transaction = Transaksi::findOrFail($id);
        $transaction->update($validatedData);

        return redirect()->route('transaksi.index')->with('success', 'Transaction updated successfully.');
    }

    public function destroy($id)
    {
        $transaction = Transaksi::findOrFail($id);
        $transaction->delete();

        return redirect()->route('transaksi.index')->with('success', 'Transaction deleted successfully.');
    }
}
