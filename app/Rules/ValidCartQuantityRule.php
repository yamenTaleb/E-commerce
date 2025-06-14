<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Facades\Auth;
use App\Models\Cart;

class ValidCartQuantityRule implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  string  $attribute  The attribute being validated (e.g., 'updates.0.quantity')
     * @param  mixed  $value  The value being validated
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     * @return void
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $index = explode('.', $attribute)[1];

        $attributeName = explode('.', $attribute)[0];

        $cartId = request()->input("{$attributeName}.{$index}.id");

        if (!$cartId) {
            $fail('The cart item ID is required.');
        }

        $cart = Cart::with('product')
            ->where('id', $cartId)
            ->where('user_id', Auth::id())
            ->first();

        if (!$cart) {
            $fail('The selected cart item is invalid.');
        }

        if (!isset($cart->product)) {
            $fail('The product for this cart item could not be found.');
        }

        if ($value > $cart->product->stock_quantity) {
            $fail("The quantity cannot be greater than {$cart->product->stock_quantity}.");
        }
    }
}
