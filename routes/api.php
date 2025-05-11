<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReviewController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});
Route::group(
    [
        'prefix' => LaravelLocalization::setLocale(),
        'middleware' => [ 'localeSessionRedirect', 'localizationRedirect', 'localeViewPath' ]
    ], function(){

});

Route::middleware('auth')->group(function () {
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::apiResource('/products', ProductController::class)->except('destroy');
Route::delete('/products/{product:slug}', [ProductController::class, 'destroy'])->name('products.destroy')->middleware('can:delete, App\Models\Product');

Route::apiResource('/reviews', ReviewController::class);
Route::apiResource('/cart', CartController::class)->except(['show', 'update', 'destroy']);
Route::patch('/cart/update', [CartController::class, 'update'])->name('cart.update');
Route::delete('/cart/destroy', [CartController::class, 'destroy'])->name('cart.destroy');

Route::apiResource('/categories', CategoryController::class);

require __DIR__.'/auth.php';
