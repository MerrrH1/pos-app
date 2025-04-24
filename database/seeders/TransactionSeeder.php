<?php

namespace Database\Seeders;

use App\Http\Controllers\TransactionController;
use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class TransactionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Transaction::truncate();
        // Transaction::create([
        //     'user_id' => 1,
        //     'customer_id' => null,
        //     'invoice_number' => TransactionController::generateInvoiceNumber(),
        //     'date' => Carbon::now(),
        //     'payment_method' => 'cash',
        //     'paid' => 0,
        //     'change' => 0,
        //     'total' => 0,
        //     'tax' => 0,
        //     'grand_total' => 0
        // ]);
    }
}
