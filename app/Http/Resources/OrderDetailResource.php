<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderDetailResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'order_id' => $this->order_id,
            'product_id' => $this->product_id,
            'quantity' => $this->quantity,
            'unit_price'=>$this->unit_price,
            'total_price'=>$this->total_price,
            'order'=>[
                'id'=>$this->order->id,
                'user_id'=>$this->order->user_id,
                'status'=>$this->order->status,
                'total_price'=>$this->order->total_price,
                'order_date'=>$this->order->order_date,
                'order_update'=>$this->order->order_update,
            ],
            'product'=>[
               'name'=>$this->product->name,
            ],
        ];
    }
}
