<?php

namespace App\Http\Controllers;

use App\Helpers\ApiResponse;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\ProductImage;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $products = Product::with('productImages')
            ->when($request->input('search'), function ($query, $search) {
                $query->where('name', 'like', '%' . $search . '%')
                    ->orWhere('description', 'like', '%' . $search . '%');
            })
            ->when($request->input('category_slug'), function ($query, $categorySlug) {
                $query->whereHas('category', function ($q) use ($categorySlug) {
                    $q->where('slug', $categorySlug); // Fetch category by slug
                });
            })
            ->when($request->input('price'), function ($query, $price) {
                $query->where('price', '<=', $price);
            })
            ->paginate(15);

        return Apiresponse::sendResponse(200, 'products retrieved successfully.', [
            'records' => ProductResource::collection($products),
            'meta' => pagination_links($products),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductRequest $request)
    {
        $data = $request->validated();

        $product = Product::create([
            'name' => $data['name'],
            'description' => $data['description'],
            'price' => $data['price'],
            'category_id' => $data['category_id'],
            'stock_quantity' => $data['stock_quantity'],
        ]);

        foreach ($data['images'] as $image) {
            (new ProductImageController)->store($image, $product->id);
        }

        return Apiresponse::sendResponse(201, 'Product created successfully.', new ProductResource($product));
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        return ApiResponse::sendResponse(200, 'product retrieved successfully.', new ProductResource($product));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductRequest $request, Product $product)
    {
        $data = $request->validated();

        $product->update([
            'name' => $data['name'],
            'description' => $data['description'],
            'price' => $data['price'],
            'category_id' => $data['category_id'],
            'stock_quantity' => $data['stock_quantity'],
        ]);

        foreach ($data['images'] as $image) {
            (new ProductImageController)->update($image, $product->id);
        }

        return ApiResponse::sendResponse(200, 'Product updated successfully.', new ProductResource($product));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        (new ProductImageController)->destroy($product->id);

        $product->delete();

        return ApiResponse::sendResponse(200, 'Product deleted successfully.', null);
    }
}
