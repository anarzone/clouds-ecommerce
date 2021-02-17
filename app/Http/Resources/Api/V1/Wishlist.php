<?php

namespace App\Http\Resources\Api\V1;

use Illuminate\Http\Resources\Json\JsonResource;

class Wishlist extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'product_id' => $this->product_id,
            'price' => $this->price,
            'sale_price' => $this->sale_price,
            'color' => $this->color,
            'size' => $this->size,
            'image' => env('APP_URL').'/storage/'.$this->image
        ];
    }
}
