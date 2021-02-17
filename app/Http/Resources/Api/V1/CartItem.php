<?php

namespace App\Http\Resources\Api\V1;

use Illuminate\Http\Resources\Json\JsonResource;

class CartItem extends JsonResource
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
            'cart_id' => $this->id,
            "product_id" => $this->product_id,
            "variant_id" => $this->variant_id,
            "price" => $this->price,
            "variant_price" => $this->variant_price,
            "sale_price" => $this->sale_price,
            'name' => $this->name,
            'image' => env('APP_URL').'/storage/'.$this->image,
            "quantity" => $this->quantity,
        ];
    }
}
