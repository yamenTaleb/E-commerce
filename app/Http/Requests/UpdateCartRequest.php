<?php

namespace App\Http\Requests;

use App\Models\Cart;
use App\Rules\ValidCartQuantityRule;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;

class UpdateCartRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        foreach ($this->input('updates') as $update) {
                $cart = Cart::findOrFail($update['id']);

                if (Auth::user()->cannot('update', $cart))
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
            'updates' => 'required|array|max:100',
            'updates.*.id' => 'required',
            'updates.*.quantity' => [
                'required',
                'integer',
                'min:1',
                new ValidCartQuantityRule(),
            ],
        ];
    }
}
