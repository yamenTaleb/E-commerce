<?php

namespace App\Http\Controllers;
use App\Services\CouponService;
use Exception;
use App\Helpers\ApiResponse;
use App\Http\Requests\StoreOrderRequest;
use App\Http\Requests\UpdateCartRequest;
use App\Http\Requests\UpdateOrderRequest;
use App\Http\Resources\OrderResource;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Services\CartService;
use App\Services\OrderService;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;

class OrderController extends Controller
{
    public function __construct(public OrderService $orderService, public CartService $cartService)
    {
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $orders = $this->orderService->orders();

        if ($orders->isEmpty())
            return ApiResponse::sendResponse(200,'No orders found',[]);

        return ApiResponse::sendResponse(200,'Orders retrieved successfully.', [
            'records' => OrderResource::collection($orders),
            'meta' => pagination_links($orders),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreOrderRequest $request, CartService $cartService, CouponService $couponService)
    {
        $order = null;

        DB::transaction(function() use ($request, &$order) {
            $order = $this->orderService->store($request);

            $this->orderService->storeOrderDetails($order);

            $this->cartService->flush();
        });

        return ApiResponse::sendResponse(200, 'Order created successfully', new OrderResource($order));
    }

    /**
     * Display the specified resource.
     */
    public function show(Order $order)
    {
        if (auth()->user()->can('view', $order))
          return ApiResponse::sendResponse(200,'Order retrieved successfully', new OrderResource($order));

        return ApiResponse::sendResponse(403,'You are not authorized to view this order', []);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateOrderRequest $request, Order $order)
    {
        $data = $request->only('status');

        $this->orderService->update($data['status'], $order);

        return ApiResponse::sendResponse(200,'Order updated successfully',new OrderResource($order));
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Order $order)
    {
        Gate::authorize('delete', Order::class);

        $order->delete();

        return ApiResponse::sendResponse(200,'Order deleted successfully', []);
    }

}
