<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ImageResource extends JsonResource
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
            'image_url' => filter_var($this->name, FILTER_VALIDATE_URL)?
                    $this->name : url('storage/products' . $this->name),
            'is_primary' => $this->is_primary
        ];
    }
}
