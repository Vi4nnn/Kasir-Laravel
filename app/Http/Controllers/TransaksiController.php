<?php

namespace App\Http\Controllers;

use DB;
use Illuminate\Http\Request;
use App\Models\Transaksi;
use App\Models\Barang;

class TransaksiController extends Controller
{
    protected $transaction;
    protected $barang;

    public function __construct(Transaksi $transaction, Barang $barang)
    {
        $this->transaction = $transaction;
        $this->barang = $barang;
    }

    public function index()
    {
        $transactions = $this->transaction->all();
        $title = 'Transaction List';
        $barangs = $this->barang->all();

        return view('transaksi.index', compact('transactions', 'title', 'barangs'));
    }

    public function create()
    {
        $barangs = $this->barang->all();
        return view('transaksi.create', compact('barangs'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'no_transaksi' => 'required|string|max:255',
            'tgl_transaksi' => 'nullable|date',
            'barang_id' => 'required|exists:barangs,id',
            'diskon' => 'nullable|integer|min:0|max:100',
            'quantity' => 'required|integer|min:1',
        ], [
            'no_transaksi.required' => 'Nomor transaksi harus diisi.',
            'barang_id.exists' => 'Barang tidak valid.',
        ]);

        $barang = Barang::findOrFail($validatedData['barang_id']);
        $harga_barang = $barang->harga;
        $quantity = $validatedData['quantity'];

        if ($barang->stok < $quantity) {
            return redirect()->back()->withErrors(['quantity' => 'Stok barang tidak mencukupi.']);
        }

        $total_bayar = $harga_barang * $quantity;

        if (isset($validatedData['diskon'])) {
            $diskon = $validatedData['diskon'];
            $total_bayar -= ($total_bayar * $diskon / 100);
        }

        $validatedData['total_bayar'] = $total_bayar;

        DB::transaction(function () use ($validatedData, $barang, $quantity) {
            $barang->stok -= $quantity;
            $barang->save();

            $this->transaction->create($validatedData);
        });

        return redirect()->route('transaksi.index')->with('success', 'Transaction created successfully.');
    }

    public function edit($id)
    {
        $transaction = $this->transaction->findOrFail($id);
        $barangs = $this->barang->all();
        return view('transaksi.edit', compact('transaction', 'barangs'));
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'no_transaksi' => 'required|string|max:255',
            'tgl_transaksi' => 'nullable|date',
            'barang_id' => 'required|exists:barangs,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $transaction = Transaksi::findOrFail($id);
        $barang = Barang::findOrFail($validatedData['barang_id']);
        $harga_barang = $barang->harga;
        $quantity = $validatedData['quantity'];
        $previous_quantity = $transaction->quantity;

        $stok_diperlukan = $quantity - $previous_quantity;

        if ($barang->stok < $stok_diperlukan) {
            return redirect()->back()->withErrors(['quantity' => 'Stok barang tidak mencukupi.']);
        }

        $total_bayar = $harga_barang * $quantity;
        $validatedData['total_bayar'] = $total_bayar;

        \DB::transaction(function () use ($transaction, $validatedData, $barang, $stok_diperlukan) {
            $barang->stok -= $stok_diperlukan;
            $barang->save();

            $transaction->update($validatedData);
        });

        return redirect()->route('transaksi.index')->with('success', 'Transaction updated successfully.');
    }

    public function destroy($id)
    {
        $transaction = Transaksi::findOrFail($id);

        \DB::transaction(function () use ($transaction) {
            $barang = Barang::findOrFail($transaction->barang_id);
            $barang->stok += $transaction->quantity;
            $barang->save();

            $transaction->delete();
        });

        return redirect()->route('transaksi.index')->with('success', 'Transaction deleted successfully.');
    }
}
