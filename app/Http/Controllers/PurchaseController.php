<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePurchaseRequest;
use App\Models\Product;
use App\Models\Purchase;
use App\Models\PurchaseItem;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class PurchaseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $purchases = Purchase::all();
        return view('purchases.index', compact('purchases'));
    }

    public function create()
    {
        $suppliers = Supplier::all();
        return view('purchases.create', compact('suppliers'));
    }

    public function store(StorePurchaseRequest $request)
    {
        $validated = $request->validated();
        $purchase = Purchase::create([
            'user_id' => Auth::id(),
            'supplier_id' => $validated['supplier_id'] ?? null,
            'date' => $validated['date'],
            'total_amount' => 0,
            'status' => "unpaid"
        ]);
        return redirect()->route('purchases.show', $purchase);
    }

    public function show(Purchase $purchase)
    {
        $products = Product::all();
        $suppliers = Supplier::all();
        return view('purchases.detail', compact('products', 'suppliers', 'purchase'));
    }

    public function setSupplier(Request $request, Purchase $purchase)
    {
        $request->validate([
            'supplier_id' => 'required|exists:suppliers,id',
        ]);

        $purchase->supplier_id = $request->supplier_id;
        $purchase->save();

        return back()->with('success', 'Supplier berhasil diperbarui.');
    }

    public static function sumTotal($purchase_id) {
        $total_amount = PurchaseItem::where('purchase_id', '=', $purchase_id)->sum('subtotal');
        Purchase::findOrFail($purchase_id)->update(['total_amount' => $total_amount]);
    }

    public function setStatus(Purchase $purchase, string $status)
    {
        if (!in_array($status, ['paid', 'cancelled'])) {
            abort(400, 'Status tidak valid');
        }

        if($status === "cancelled" && $purchase->status !== "cancelled") {
            foreach ($purchase->purchaseItems as $item) {
                $product = $item->product;
                $product->decrement('stock', $item->quantity);
            }
        }

        $purchase->status = $status;
        $purchase->save();

        return redirect()->back()->with('success', 'Status transaksi diperbarui.');
    }
}
