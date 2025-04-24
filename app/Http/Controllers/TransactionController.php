<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTransactionRequest;
use App\Models\Customer;
use App\Models\Product;
use App\Models\Transaction;
use App\Models\TransactionItem;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $transactions = Transaction::all();
        return view('transactions.index', compact('transactions'));
    }

    public static function generateInvoiceNumber()
    {
        $prefix = "INV-" . Carbon::now()->format('Ymd');
        $count = Transaction::whereDate('created_at', '=', Carbon::today())->count() + 1;
        return $prefix . '-' . str_pad($count, 4, '0', STR_PAD_LEFT);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $customers = Customer::all();
        $invoiceNumber = self::generateInvoiceNumber();
        return view('transactions.create', compact('customers', 'invoiceNumber'));
    }

    public function store(StoreTransactionRequest $storeTransactionRequest) {
        $validated = $storeTransactionRequest->validated();
        $transaction = Transaction::create([
            'user_id' => Auth::id(),
            'customer_id' => $validated['customer_id'] ?? null,
            'invoice_number' => self::generateInvoiceNumber(),
            'date' => $validated['date'],
            'total_amount' => 0,
            'status' => "unpaid",
        ]);
        return redirect()->route('transactions.show', $transaction);
    }

    /**
     * Display the specified resource.
     */
    public function show(Transaction $transaction)
    {
        $customers = Customer::all();
        $products = Product::all();
        return view('transactions.detail', compact('transaction', 'products', 'customers'));
    }

    public function setStatus(Transaction $transaction, string $status)
    {
        if (!in_array($status, ['paid', 'cancelled'])) {
            abort(400, 'Status tidak valid');
        }

        if($status === "cancelled" && $transaction->status !== "cancelled") {
            foreach ($transaction->transactionItems as $item) {
                $product = $item->product;
                $product->increment('stock', $item->quantity);
            }
        }

        $transaction->status = $status;
        $transaction->save();

        return redirect()->back()->with('success', 'Status transaksi diperbarui.');
    }

    public static function sumTotal($transaction_id) {
        $total_amount = TransactionItem::where('transaction_id', '=', $transaction_id)->sum('subtotal');
        Transaction::findOrFail($transaction_id)->update(['total_amount' => $total_amount]);
    }

    public function setCustomer(Request $request, Transaction $transaction) {
        $transaction->update(['customer_id' => $request->customer_id]);
        return redirect()->back()->with('success', 'Pelanggan berhasil disimpan untuk transaksi ' . $transaction->invoice_number);
    }
}
