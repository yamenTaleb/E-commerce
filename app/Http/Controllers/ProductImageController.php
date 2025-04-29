<?php

namespace App\Http\Controllers;

use App\Models\ProductImage;
use App\Http\Requests\StoreProductImageRequest;
use App\Http\Requests\UpdateProductImageRequest;

class ProductImageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store($image, $product_id)
    {
        if (filter_var($image['name'], FILTER_VALIDATE_URL))
            $imageName = $image['name'];
        else
            $imageName = storeImage($image['name'], 'products');

        ProductImage::create([
            'product_id' => $product_id,
            'name' => $imageName,
            'is_primary' => $image['is_primary'],
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(ProductImage $productImage)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ProductImage $productImage)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update($image, $product_id)
    {
        if (isset($image['id'])) {
            $productImage = ProductImage::findOrFail($image['id']);

            if (filter_var($image['name'], FILTER_VALIDATE_URL))
                $imageName = $image['name'];
            else {
                deleteImage($productImage->name,'products');

                $imageName = storeImage($image['name'], 'products');
            }

            $productImage->update([
                'name' => $imageName,
                'is_primary' => $image['is_primary'],
            ]);
        } else
            $this->store($image, $product_id);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($product_id)
    {
        $images = ProductImage::query()->where('product_id', $product_id)->get();

        foreach ($images as $image) {
            deleteImage($image->name,'products');
        }
    }
}
