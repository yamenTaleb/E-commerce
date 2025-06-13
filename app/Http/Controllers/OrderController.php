<?php

namespace App\Http\Controllers;
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
    public function __construct(public OrderService $orderService)
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
    public function store(StoreOrderRequest $request)
    {
        try{
            $request->validated();

            DB::transaction(function() use($request){

              $order=Order::create([
               'user_id'=>$request->user_id,
               'order_date'=>now(),
               'order_update'=>null,
               'total_price'=>0,
               'status'=>'unpaid',
              ]);
              $user=auth()->user();

             $orderservice=new OrderService();
             $totalprice= $orderservice->creatOrderDetailsWithReturnTotalPrice($user,$order);
             $order->update(['total_price'=>$totalprice]);

             return ApiResponse::sendResponse(201,'Order created successfully',new OrderResource($order));
            });
        }
        catch (Exception $e){
            $errorData=json_decode($e->getMessage(),true) ?? [];
            return ApiResponse::sendResponse($e->getCode() ?? 422,$errorData['message'] ?? $e->getMessage(),$errorData['data'] ?? [] );
        }

    }

    /**
     * Display the specified resource.
     */
    public function show(Order $order)
    {
      if(auth()->user()->can('view',$order)){

          return ApiResponse::sendResponse(200,'Order retrived successfully',new OrderResource($order));
      }
          return ApiResponse::sendResponse(403,'You are not authorized to view this order',[]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateOrderRequest $request, Order $order)
    {

        try{

           $request->validated();
         return DB::transaction(function() use($request,$order){
             $user=auth()->user();
             $carts=$user->cartItems()->with('product')->get;

             if($carts->isEmpty())
             {
                 return ApiResponse::sendResponse(200,'you did not add any cart',[]);
             }

             $updateorder=$order->update([
                 'user_id'=>$request->user_id,
                 'order_update'=>now(),
             ]);

             $orderservice=new OrderService();
             $totalprice= $orderservice->UpdateOrderDetails($user,$order);

             $order->update(['total_price'=>$totalprice]);

             return ApiResponse::sendResponse(200,'Order updated successfully',new OrderResource($updateorder));
         });

        }
        catch (Exception $e){
            $errorData=json_decode($e->getMessage(),true) ?? [];
            return ApiResponse::sendResponse($e->getCode() ?? 422,$errorData['message'] ?? $e->getMessage(),$errorData['data'] ?? [] );
        }

    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Order $order)
    {
        if(auth()->user()->can('delete', $order)){
            $ordersdetails=OrderDetail::where('order_id',$order->id)->get;
            foreach ($ordersdetails as $orderdetail){
                $orderdetail->delete();
            }
            $order->delete();
            return ApiResponse::sendResponse(200,'Order deleted successfully',[]);
        }
        return ApiResponse::sendResponse(403,'You are not authorized to delete this order',[]);
    }

}
