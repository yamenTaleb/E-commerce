<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'bail|required|unique:products|string|max:255',
            'description' => 'bail|required',
            'price' => 'bail|required|numeric',
            'images.*.name' => 'bail|required|url',
            'images.*.is_primary' => 'boolean',
            'category_id' => 'bail|required|integer|exists:categories,id',
            'stock_quantity' => 'bail|required|integer|min:1',
        ];
    }
}
