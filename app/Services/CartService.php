<?php

namespace App\Services;

use App\Models\Cart;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;

class CartService
{
    public static function cartItems(): Collection
    {
        $cartItems = Cart::with('product:id,name,price,stock_quantity,discount')
            ->where('user_id', Auth::user()->id)
            ->get();

        return $cartItems;
    }

    public function flush(): void
    {
        Cart::where('user_id', Auth::user()->id)
            ->delete();
    }
}
