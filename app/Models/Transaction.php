<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;

class Transaction extends Model
{
    /** @use HasFactory<\Database\Factories\TransactionFactory> */
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'customer_id',
        'invoice_number',
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

    public function customer() {
        return $this->belongsTo(Customer::class);
    }
    
    public function transactionItems() {
        return $this->hasMany(TransactionItem::class);
    }
}
