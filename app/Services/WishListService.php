<?php

namespace App\Services;

use App\Http\Requests\StoreWishListRequest;
use App\Models\Cart;
use App\Models\WishList;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;

class WishListService
{
    public function WishListItems(): Collection
    {
        $WishListItems = WishList::with('product:id,name,price,stock_quantity,discount')
            ->where('user_id', Auth::user()->id)
            ->get();

        return $WishListItems;
    }

    public function flush(): void
    {
        Cart::where('user_id', Auth::user()->id)
            ->delete();
    }

    public function store(StoreWishListRequest $request): WishList
    {
        return WishList::create([
            'user_id' => $request->user_id,
            'product_id' => $request->product_id,
            'comment' => $request->comment,
        ]);
    }
}
