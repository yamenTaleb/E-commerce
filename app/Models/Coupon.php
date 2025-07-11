<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    /** @use HasFactory<\Database\Factories\CouponFactory> */
    use HasFactory;

    protected $fillable = [
        'code',
        'expires_at',
        'discount_amount',
    ];

    protected $casts = [
        'expires_at' => 'datetime',
    ];

    public $timestamps = false;

    public function isExpired(): bool
    {
        return $this->expires_at && $this->expires_at->isPast();
    }

    public static function exists(string $code): bool
    {
        $coupon = static::where('code', $code)->first();

        return (bool) $coupon;
    }

}
