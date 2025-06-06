<?php

namespace App\Services;

use App\Helpers\ApiResponse;
use App\Models\Cart;
use App\Models\Product;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CartService
{

    public static function cartItems(): Collection
    {
        $cartItems = Cart::with('product:id,name,price,stock_quantity')
            ->where('user_id', Auth::user()->id)
            ->get();

        return $cartItems;
    }


}
