<?php

namespace App\Http\Requests;

use App\Models\Cart;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class DestroyCartRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        foreach ($this->input('array_of_ids') as $id) {
            $cart = Cart::findOrFail($id);

            if (Auth::user()->cannot('delete', $cart))
                return false;
        }

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
            'array_of_ids' => 'required|array',
            'array_of_ids.*' => 'required|integer|exists:carts,id'
        ];
    }
}
