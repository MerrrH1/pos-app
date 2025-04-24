<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePurchaseItemRequest;
use App\Http\Requests\UpdatePurchaseItemRequest;
use App\Models\Product;
use App\Models\Purchase;
use App\Models\PurchaseItem;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PurchaseItemController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $purchaseItems = PurchaseItem::all();
        return view('purchases.index', compact('purchaseItems'));
    }

    public function store(StorePurchaseItemRequest $request)
    {
        $validated = $request->validated();

        $product = Product::findOrFail($validated['product_id']);

        $exists = PurchaseItem::where('purchase_id', '=', $validated['purchase_id'])
            ->where('product_id', '=', $product->id)
            ->exists();

        if ($exists) {
            return back()->with('error', 'Produk sudah ada dalam pembelian. Silakan edit jumlahnya di daftar item.');
        }

        DB::beginTransaction();
        try {
            PurchaseItem::create([
                'purchase_id' => $validated['purchase_id'],
                'product_id' => $product->id,
                'quantity' => $validated['quantity'],
                'price' => $product->cost,
                'subtotal' => $validated['quantity'] * $product->cost
            ]);
            PurchaseController::sumTotal($validated['purchase_id']);
            $product->increment('stock', $validated['quantity']);
            DB::commit();
            return back()->with('success', 'Produk berhasil ditambahkan ke pembelian!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan saat menambahkan produk: ' . $e->getMessage());
        }
    }

    public function update(UpdatePurchaseItemRequest $request, PurchaseItem $purchaseItem) {
        $validated = $request->validated();
        $oldQuantity = $purchaseItem->quantity;
        $newQuantity = $validated['quantity'];
        $product = $purchaseItem->product;
        
        DB::beginTransaction();
        try {
            $difference = $newQuantity - $oldQuantity;

            if($difference > 0) {
                $product->increment('stock', $difference);
            } elseif ($difference < 0) {
                $product->decrement('stock', abs($difference));
            }

            $purchaseItem->update([
                'quantity' => $newQuantity,
                'subtotal' => $product->cost * $newQuantity
            ]);

            PurchaseController::sumTotal($purchaseItem->purchase_id);
            DB::commit();
            return redirect()->back()->with('success', 'Item pembelian berhasil diperbarui!');
        } catch (\Throwable $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Terjadi Kesalahan : ' . $e->getMessage());
        }
    }
}
