<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\User;
use App\Models\TransactionDetail;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer',
        'total',
        'discount',
        'pay',
        'change',
        'cashier'
    ];

public function user()
{
    return $this->belongsTo(User::class, 'cashier');
}


    public function details()
    {
        return $this->hasMany(TransactionDetail::class);
    }
}
