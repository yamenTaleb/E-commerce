<?php

namespace App\Http\Controllers;

use App\Helpers\ApiResponse;
use App\Http\Resources\WishListResource;
use App\Models\WishList;
use App\Http\Requests\StoreWishListRequest;
use App\Http\Requests\UpdateWishListRequest;
use App\Services\WishListService;
use Illuminate\Support\Facades\Gate;

class WishListController extends Controller
{
    public function __construct(public WishListService $wishListService)
    {
    }
    public function index()
    {
        $wishList = $this->wishListService->WishListItems();
        if ($wishList->isEmpty())
            return ApiResponse::sendResponse(200, 'No items in your Wish List', null);

        return ApiResponse::sendResponse(200, 'Wish List items retrieved successfully', WishListResource::collection($wishList));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreWishListRequest $request)
    {
        return ApiResponse::sendResponse(
            200,
            'Product added to Wish List successfully',
            new WishListResource($this->wishListService->store($request))
        );
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(WishList $wishList)
    {
        Gate::authorize('delete', $wishList);

        $wishList->delete();

        return ApiResponse::sendResponse(
            200,
            'Product removed from Wish List successfully',
            null,
        );
    }
}
