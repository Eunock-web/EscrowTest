<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaymentLog extends Model
{
    protected $table = 'payments_logs';

    protected $fillable = [
        'transaction_id',
        'status',
        'payload',
        'product_id',
        'buyer_id',
    ];

    protected $casts = [
        'payload' => 'json',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function buyer()
    {
        return $this->belongsTo(User::class, 'buyer_id');
    }
}
