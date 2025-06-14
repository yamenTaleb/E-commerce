<?php

namespace App\Rules;

use App\Models\Coupon;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class ValidCouponRule implements ValidationRule
{

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $isExpired = Coupon::where('code', $value)->first()->isExpired();

        if ($isExpired) {
            $fail('Coupon is expired');
        }
    }
}
