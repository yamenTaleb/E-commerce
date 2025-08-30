<?php

namespace App\Services;
use App\Http\Requests\StoreOrderRequest;
use App\Http\Requests\UpdateOrderRequest;
use App\Http\Resources\OrderResource;
use App\Models\Order;
use Exception;
use App\Helpers\ApiResponse;
use App\Models\OrderDetail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Request;

class OrderService
{
    public function __construct(
        public CartService $cartService,
        public CouponService $couponService
    )
    {
    }

    public function storeOrderDetails($order)
    {
        DB::transaction(function () use ($order) {
            $carts = $this->cartService->cartItems();

            foreach ($carts as $cart) {

                $unit_price = $cart->product->price - $cart->product->price * $cart->product->discount / 100;

                OrderDetail::create([
                    'order_id' => $order->id,
                    'product_id' => $cart->product_id,
                    'quantity' => $cart->quantity,
                    'price' => $unit_price,
                ]);

                $cart->product->decrement('stock_quantity', $cart->quantity);
            }
        });
    }

    // admin with all orders user with all their orders
    public function orders()
    {
        if (Auth::user()->can('viewAny', Order::class))
            return Order::paginate(15);

        return Order::where('user_id', Auth::user()->id)->paginate(15);
    }

    public function store($request)
    {
        return Order::create([
            'user_id' => Auth::user()->id,
            'order_date' => now(),
            'total_price' => $this->total($request),
            'session_id' => $request->session_id ?? null,
            'status' => 'unpaid',
        ]);
    }

    public function update($status, Order $order)
    {
       $order->status = $status;
       $order->order_update = now();
       $order->save();

       return $order->fresh();
    }

    // calculate the total considering the discounts and coupons
    public function total(StoreOrderRequest $request)
    {
        return $this->cartService->cartItems()->sum(function ($cart) {
                return $cart->product->price * $cart->quantity - (int) ($cart->product->price * $cart->quantity * $cart->product->discount / 100);
            }) - when($request->has('coupon'), function () use ($request) {
                return $this->couponService->discount($request->coupon);
            });
    }
}
