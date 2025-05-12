<?php

namespace App\Http\Controllers;

use App\Helpers\ApiResponse;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use Illuminate\Support\Facades\Gate;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::with('childrenCategories')
                        ->whereNull('category_parent_id')
                        ->orderBy('name')
                        ->get();

        return ApiResponse::sendResponse(200, 'Categories retrieved successfully.', CategoryResource::collection($categories));
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCategoryRequest $request)
    {
        $data = $request->validated();

        $category = Category::create([
            'name' => $data['name'],
            'description' => $data['description'],
            'category_parent_id' => $data['category_parent_id'] ?? null,
        ]);

        return ApiResponse::sendResponse(201, 'Category created successfully.', new CategoryResource($category));
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        Gate::authorize('view', $category);

        return ApiResponse::sendResponse(200, 'Category retrieved successfully.', CategoryResource::make($category));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCategoryRequest $request, Category $category)
    {
        $data = $request->validated();

        $category->update([
            'name' => $data['name'],
            'description' => $data['description'],
            'category_parent_id' => $data['category_parent_id'] ?? null,
        ]);

        return ApiResponse::sendResponse(200, 'Category updated successfully.', new CategoryResource($category));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        Gate::authorize('delete', $category);

        $category->delete();

        return ApiResponse::sendResponse(200, 'Category deleted successfully.', null);
    }
}
