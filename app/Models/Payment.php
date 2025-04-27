<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Payment extends Model
{
    /** @use HasFactory<\Database\Factories\PaymentFactory> */
    use HasFactory;
    protected $fillable = [
        'order_id',
        'payment_method',
        'payment_status',
        'payment_date',
        'payment_amount',
    ];

    function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }
}
