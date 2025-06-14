<?php

namespace App\Http\Requests;

use App\Enums\OrderStatusEnum;
use App\Models\Order;
use Illuminate\Foundation\Http\FormRequest;

class UpdateOrderRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user()->can('update', Order::class);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
           'status'=> 'sometimes|in:' . OrderStatusEnum::PENDING->value . ',' . OrderStatusEnum::DELIVERED->value . ',' . OrderStatusEnum::CANCELED->value . ',' . OrderStatusEnum::SHIPPED->value
             . ',' . OrderStatusEnum::PAID->value . ',' . OrderStatusEnum::REFUNDED->value . ',' . OrderStatusEnum::UNPAID->value . ',' . OrderStatusEnum::PROCESSING->value,
        ];
    }
}
