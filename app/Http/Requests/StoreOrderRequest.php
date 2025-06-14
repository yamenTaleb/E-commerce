<?php

namespace App\Http\Requests;

use App\Models\Order;
use App\Rules\ValidCartQuantityRule;
use App\Rules\ValidCouponRule;
use App\Rules\ValidOrderQuantityRule;
use App\Services\CartService;
use Illuminate\Foundation\Http\FormRequest;

class StoreOrderRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user()->can('create', Order::class);
    }

    protected function prepareForValidation()
    {
        $cartItems = CartService::cartItems()->map(function ($item) {
            return [
                'id' => $item->id,
                'quantity' => $item->quantity,
                'product_quantity' => $item->product->stock_quantity,
                'product_name' => $item->product->name,
            ];
        })->toArray();

        return $this->merge([
            'cartItems' => $cartItems,
        ]);
    }
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'coupon' => [
                'string',
                'exists:coupons,code',
                new ValidCouponRule,
            ],
            'cartItems' => [
                'required',
                'array',
                new ValidOrderQuantityRule,
            ],
        ];
    }
}
