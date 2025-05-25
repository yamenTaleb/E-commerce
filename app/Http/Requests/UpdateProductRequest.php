<?php

namespace App\Http\Requests;

use App\Models\Product;
use App\Rules\OnePrimaryImageRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class UpdateProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user()->can('update', Product::class);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'bail|string|unique:products|max:255',
            'description' => 'bail|string|max:22222',
            'price' => 'numeric',
            'stock_quantity' => 'bail|integer|min:1',
            'category_id' => 'integer|exists:categories,id',
            'images' => new OnePrimaryImageRule,
            'images.*.id' => 'present',
            'images.*.name' =>  'url',
            'images.*.is_primary' => 'boolean',
        ];
    }
}
