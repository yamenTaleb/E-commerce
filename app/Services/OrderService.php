<?php

namespace App\Services;
use App\Http\Resources\OrderResource;
use App\Models\Order;
use Exception;
use App\Helpers\ApiResponse;
use App\Models\OrderDetail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrderService
{

    public function creatOrderDetailsWithReturnTotalPrice($user,$order)
    {
        try {
            return DB::transaction(function () use ($order,$user) {
                $carts=$this->validationOfCarts($user);
                $totalprice=0;
                foreach ($carts as $cart) {
                    OrderDetail::create([
                        'order_id' => $order->id,
                        'product_id' => $cart->product_id,
                        'quantity' => $cart->quantity,
                        'unit_price' => $cart->product->price,
                        'total_price' => $cart->product->price * $cart->quantity,
                    ]);
                    $totalprice += $cart->quantity * $cart->product->price;
                    $cart->product->decrement('stock_quantity', $cart->quantity);
                }
                return $totalprice;
            });

        }
        catch (Exception $e) {
            throw new Exception($e->getMessage());
        }

    }

    public function UpdateOrderDetails($user,$order)
    {
        try
        {
          return  DB::transaction(function () use ($user,$order) {
                $this->returnItemsToStock($order);
                $carts=$this->validationOfCarts($user);

                $totalprice=0;
                foreach ($carts as $cart) {
                    OrderDetail::where('order_id', $order->id)
                        ->where('product_id', $cart->product_id)
                        ->update([
                            'order_id' => $order->id,
                            'product_id' => $cart->product_id,
                            'quantity' => $cart->quantity,
                            'unit_price' => $cart->product->price,
                            'total_price' => $cart->product->price * $cart->quantity,
                    ]);
                    $totalprice += $cart->quantity * $cart->product->price;
                    $cart->product->decrement('stock_quantity', $cart->quantity);
                }
                return $totalprice;

            });

        }
        catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    private function returnItemsToStock($order): void
    {
       foreach ($order->orderDetails as $orderDetail) {
         $orderDetail->product()->increment('stock_quantity', $orderDetail->quantity);
       }
    }

    private function validationOfCarts($user)
    {
        $carts=$user->cartItems()->with('product')->get;

        if($carts->isEmpty())
        {
            throw new Exception ('you did not add any cart',200);
        }

        foreach ($carts as $cart) {
            if ($cart->product->stock_quantity < $cart->quantity) {
                throw new Exception ( json_encode([
                    'quantity of products in stock is not enough ',
                    'data'=>[
                        'cart_id' => $cart->id,
                        'requested quantity in cart ' => $cart->quantity,
                        'available stock quantity' => $cart->product->stock_quantity,
                        'product_id' => $cart->product_id  ]
                ]),422);
            }
        }
        return $carts;
    }

    // admin all orders user all their orders
    public function orders()
    {
        if (Auth::user()->can('viewAny', Order::class))
            return Order::paginate(15);

        return Order::where('user_id', Auth::user()->id)->paginate(15);
    }
}
