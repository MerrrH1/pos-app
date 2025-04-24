<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TransactionItem extends Model
{
    /** @use HasFactory<\Database\Factories\TransactionItemFactory> */
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'transaction_id',
        'product_id',
        'quantity',
        'price',
        'discount',
        'subtotal'
    ];

    public function transaction() {
        return $this->belongsTo(Transaction::class);
    }

    public function product() {
        return $this->belongsTo(Product::class);
    }
}
