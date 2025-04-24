<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTransactionItemRequest;
use App\Http\Requests\UpdateTransactionItemRequest;
use App\Models\Product;
use App\Models\Transaction;
use App\Models\TransactionItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class TransactionItemController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $transactionItems = TransactionItem::orderBy('id');
        return view('transactions.index', $transactionItems);
    }

    public function store(StoreTransactionItemRequest $request)
    {
        $validated = $request->validated();
        $product = Product::findOrFail($validated['product_id']);

        $exists = TransactionItem::where('transaction_id', $validated['transaction_id'])
            ->where('product_id', $product->id)->exists();
            
        if ($exists) {
            return back()->with('error', 'Produk sudah ada dalam transaksi. Silakan edit jumlahnya di daftar item.');
        }

        if ($validated['quantity'] > $product->stock) {
            return back()->with('error', 'Jumlah produk melebihi stok yang tersedia');
        }
        DB::beginTransaction();
        TransactionItem::create([
            'transaction_id' => $validated['transaction_id'],
            'product_id' => $product->id,
            'quantity' => $validated['quantity'],
            'price' => $product->price,
            'subtotal' => $validated['quantity'] * $product->price
        ]);
        TransactionController::sumTotal($validated['transaction_id']);
        $product->decrement('stock', $validated['quantity']);
        DB::commit();
        return back()->with('success', 'Produk berhasil ditambahkan ke transaksi!');
    }

    public function update(Request $request, TransactionItem $transactionItem)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1'
        ]);

        $oldQuantity = $transactionItem->quantity;
        $newQuantity = $request->quantity;
        $product = $transactionItem->product;
        $availableStock = $oldQuantity + $product->stock;

        if ($newQuantity > $availableStock) {
            return back()->with('error', 'Jumlah produk melebihi stok yang tersedia');
        }

        DB::beginTransaction();
        try {
            $difference = $newQuantity - $oldQuantity;

            if ($difference > 0) {
                $product->decrement('stock', $difference);
            } elseif ($difference < 0) {
                $product->increment('stock', abs($difference));
            }

            $transactionItem->update([
                'quantity' => $newQuantity,
                'subtotal' => $newQuantity * $product->price
            ]);
            TransactionController::sumTotal($transactionItem->transaction_id);
            DB::commit();
            return redirect()->back()->with('success', 'Item transaksi berhasil diperbarui!');
        } catch (\Throwable $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Terjadi Kesalahan : ' . $e->getMessage());
        }
    }

    public function destroy(TransactionItem $transactionItem)
    {
        try {
            $product = $transactionItem->product;

            $product->increment('stock', $transactionItem->quantity);

            $transactionItem->delete();

            TransactionController::sumTotal($transactionItem->transaction_id);

            return back()->with('success', 'Item berhasil dihapus dari transaksi!');
        } catch (\Throwable $e) {
            Log::error('Gagal menghapus item transaksi', ['error' => $e->getMessage()]);
            return back()->with('error', 'Terjadi kesalahan saat menghapus item transaksi.');
        }
    }
}
