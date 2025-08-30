<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Product;

class TransactionDetail extends Model
{
    protected $fillable = ['transaction_id', 'product_id', 'qty', 'price', 'subtotal'];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function transaction()
    {
        return $this->belongsTo(Transaction::class);
    }
}
