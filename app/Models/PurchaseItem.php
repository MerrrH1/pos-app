<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PurchaseItem extends Model
{
    /** @use HasFactory<\Database\Factories\PurchaseItemFactory> */
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'purchase_id',
        'product_id',
        'price',
        'quantity',
        'subtotal'
    ];

    public function purchase() {
        return $this->belongsTo(Purchase::class);
    }

    public function product() {
        return $this->belongsTo(Product::class);
    }
}
