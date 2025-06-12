<?php

namespace App\Services;

use App\Models\Coupon;
use App\Models\User;
use App\Rules\ValidCouponRule;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class CouponService
{
    public function coupons()
    {
        return Coupon::paginate(15);
    }

    public function store($coupon)
    {
        return Coupon::create([
            'code' => $coupon['code'],
            'discount_amount' => $coupon['discount_amount'],
            'expires_at' => $coupon['expires_at'],
        ]);
    }

    public function update($coupon, $data)
    {
        $coupon->update([
            'code' => $data['code'],
            'discount_amount' => $data['discount_amount'],
            'expires_at' => $data['expires_at'],
        ]);
        
        return $coupon->fresh();
    }

}
