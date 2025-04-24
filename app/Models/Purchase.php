<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Purchase extends Model
{
    /** @use HasFactory<\Database\Factories\PurchaseFactory> */
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'supplier_id',
        'date',
        'total_amount',
        'status'
    ];

    public function casts() {
        return [
            'date' => 'datetime'
        ];
    }

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function supplier() {
        return $this->belongsTo(Supplier::class);
    }
    
    public function purchaseItems() {
        return $this->hasMany(PurchaseItem::class);
    }
}
