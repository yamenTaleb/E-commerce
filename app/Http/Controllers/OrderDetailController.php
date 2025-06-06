<?php

namespace App\Http\Controllers;

use App\Helpers\ApiResponse;
use App\Http\Resources\OrderDetailResource;
use App\Models\OrderDetail;
use Illuminate\Http\Request;

class OrderDetailController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if(auth()->user()->can('viewAny'))
        {
            $ordersdetails = OrderDetail::with(['order:id,user_id,status,total_price,order_date, order_update','product:name'])->paginate(10);

            return ApiResponse::sendResponse(200,'All orders details retrived successfully',
                [
                    'order_details'=>OrderDetailResource::collection($ordersdetails),
                    'meta' => pagination_links($ordersdetails),
                ]);
        }

            $ordersdetails = OrderDetail::whereHas('order', function($query){
                $query->where('user_id',auth()->id());
            })->with(['order:id,user_id,status,total_price,order_date,order_update',
                'product:name'])
                ->paginate(10);

            foreach($ordersdetails as $ordersdetail){
                if( auth()->user()->cannot('view',$ordersdetail))
                    return ApiResponse::sendResponse(403,'You are not authorized to view orders details',[]);
            }

            return ApiResponse::sendResponse(200,'All orders details for you retrived successfully',
                [
                    'order_details'=>OrderDetailResource::collection($ordersdetails),
                    'meta' => pagination_links($ordersdetails),
                ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {


    }

    /**
     * Display the specified resource.
     */
    public function show(OrderDetail $orderDetail)
    {
        if(auth()->user()->can('view', $orderDetail)){
            $orderDetail->load(['order:id,user_id,status,total_price,order_date,order_update','product:name']);
            return ApiResponse::sendResponse(200,' This order details retrived successfully',new OrderDetailResource($orderDetail) );
        }
        return ApiResponse::sendResponse(403,'You are not authorized to view order_details',[]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
