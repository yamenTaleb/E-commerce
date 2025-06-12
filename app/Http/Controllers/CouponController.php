<?php

namespace App\Http\Controllers;

use App\Helpers\ApiResponse;
use App\Http\Resources\CouponResource;
use App\Models\Coupon;
use App\Http\Requests\StoreCouponRequest;
use App\Http\Requests\UpdateCouponRequest;
use App\Services\CouponService;
use Illuminate\Support\Facades\Gate;
use function Filament\authorize;

class CouponController extends Controller
{
    public function __construct(public CouponService $couponService)
    {
    }

    public function index()
    {
        $coupons = $this->couponService->coupons();

        return ApiResponse::sendResponse(200, 'Coupons retrieved successfully', [
            'records' => CouponResource::collection($coupons),
            'meta' => pagination_links($coupons)
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCouponRequest $request)
    {
        $coupon = $request->validated();

        $coupon = $this->couponService->store($coupon);

        return ApiResponse::sendResponse(201, 'Coupon created successfully.', new CouponResource($coupon));
    }

    /**
     * Display the specified resource.
     */
    public function show(Coupon $coupon)
    {
        return ApiResponse::sendResponse(200, 'Coupon retrieved successfully.', new CouponResource($coupon));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCouponRequest $request, Coupon $coupon)
    {
        $data = $request->validated();

        $coupon = $this->couponService->update($coupon, $data);

        return ApiResponse::sendResponse(200, 'Coupon updated successfully.', new CouponResource($coupon));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Coupon $coupon)
    {
        Gate::authorize('delete', $coupon);

        $coupon->delete();

        return ApiResponse::sendResponse(200, 'Coupon deleted successfully.', null);
    }
}
