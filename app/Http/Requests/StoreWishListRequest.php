<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreWishListRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    protected function prepareForValidation()
    {
        return $this->merge([
            'user_id' => auth()->user()->id
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
            'comment' => 'string|max:2048|nullable',
            'product_id' => 'required|integer|exists:products,id|unique:wish_lists,id,product_id',
        ];
    }
}
