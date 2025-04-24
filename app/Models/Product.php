<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    /** @use HasFactory<\Database\Factories\ProductFactory> */
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'category_id',
        'unit_id',
        'price',
        'cost',
        'stock'
    ];

    public function category() {
        return $this->belongsTo(Category::class);
    }

    public function unit() {
        return $this->belongsTo(Unit::class);
    }

    public function transactionItems() {
        return $this->hasMany(TransactionItem::class);
    }

    public function purchaseItems() {
        return $this->hasMany(PurchaseItem::class);
    }
}
