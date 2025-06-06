<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
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
            'user_id' => $this->user_id,
            'order_status' => $this->status ?? 'unpaid',
            'total_price'=>$this->total_price,
            'order_date'=>$this->order_date,
            'order_update'=>$this->order_update ?? 'null'
        ];
    }
}
