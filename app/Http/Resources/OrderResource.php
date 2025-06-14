<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Carbon;

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
            'status' => $this->status,
            'user_id' => $this->user_id,
            'total'=> $this->total_price,
            'order_date'=> Carbon::parse($this->order_date)->format('Y-m-d h:i a'),
            'updated_at'=> Carbon::parse($this->order_update)->format('Y-m-d h:i a'),
        ];
    }
}
