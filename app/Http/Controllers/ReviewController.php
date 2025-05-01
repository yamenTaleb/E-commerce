<?php

namespace App\Http\Controllers;

use App\Helpers\ApiResponse;
use App\Http\Resources\ReviewResource;
use App\Models\Review;
use App\Http\Requests\StorereviewRequest;
use App\Http\Requests\UpdatereviewRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class ReviewController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $reviews = review::with('user')
            ->where('product_id', $request->input('product_id'))
            ->paginate(10);

        return ApiResponse::sendResponse(200, 'Reviews retrieved successfully', ReviewResource::collection($reviews));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorereviewRequest $request)
    {
        $data = $request->validated();

        $review = Review::create([
            'product_id' => $data['product_id'],
            'user_id' => $data['user_id'],
            'rating' => $data['rating'],
            'comment' => $data['comment'],
        ]);

        return ApiResponse::sendResponse(200, 'Review created successfully', new ReviewResource($review));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateReviewRequest $request, Review $review)
    {
        $request->validated();

        $review->update([
            'rating' => $request->rating,
             'comment' => $request->comment,
        ]);

        return ApiResponse::sendResponse(200, 'Review updated successfully', new ReviewResource($review));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Review $review)
    {
        Gate::authorize('delete', $review);

        $review->delete();

        return ApiResponse::sendResponse(200, 'Review deleted successfully', null);
    }
}
