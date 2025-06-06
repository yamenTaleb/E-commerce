<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class shipment extends Model
{
    /** @use HasFactory<\Database\Factories\ShipmentFactory> */
    use HasFactory;
    protected $fillable = [
        'order_id',
        'shipment_date',
        'delivery_date',
        'shipment_status',
    ];

    public $timestamps = false;

    protected $casts = [
        'shipment_date' => 'datetime',
        'delivery_date' => 'datetime',
    ];

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }
}
