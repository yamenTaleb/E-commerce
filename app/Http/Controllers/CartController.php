<?php

namespace App\Http\Controllers;

use App\Helpers\ApiResponse;
use App\Http\Requests\DestroyCartRequest;
use App\Http\Resources\CartResource;
use App\Models\Cart;
use App\Http\Requests\StoreCartRequest;
use App\Http\Requests\UpdateCartRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $cartItems = Cart::with('product:id,name,price,stock_quantity')
            ->where('user_id', auth()->user()->id)
            ->get();

        if ($cartItems->isEmpty())
            return ApiResponse::sendResponse(200, 'No items in your cart', null);

        return ApiResponse::sendResponse(200, "cartItems retrieved successfully.", CartResource::collection($cartItems));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCartRequest $request)
    {
       $data = $request->validated();

      $cartItem = Cart::create([
           'user_id' => $data['user_id'],
           'product_id' => $data['product_id'],
           'quantity' => $data['quantity'],
       ]);

       return ApiResponse::sendResponse(201, 'Item added to cart successfully.', new CartResource($cartItem));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCartRequest $request)
    {
        $data = $request->validated();
        $data = $data['updates'];
        $cartItems = [];

        DB::transaction(function () use ($data, &$cartItems) {
            foreach ($data as $item) {

                Cart::query()
                    ->where('id', $item['id'])
                    ->update([
                    'quantity' => $item['quantity'],
                ]);

                $cartItems[] = Cart::findOrFail($item['id']);
            }
        });

        return ApiResponse::sendResponse(201, 'Cart items updated successfully.', CartResource::collection($cartItems));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DestroyCartRequest $request)
    {
        $data = $request->validated();

        DB::transaction(function () use ($data) {
            foreach ($data['array_of_ids'] as $id) {

                $cartItem = Cart::findOrFail($id);

                $cartItem->delete();
            }
        });

        return ApiResponse::sendResponse(200, 'Cart items deleted successfully.', null);
    }
}
