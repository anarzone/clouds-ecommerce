<?php

namespace App\Http\Resources\Api\V1;

use Illuminate\Http\Resources\Json\JsonResource;

class Product extends JsonResource
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
            'sku' => $this->sku,
            'quantity' => $this->quantity,
            'price' => $this->price,
            'sale_price' => $this->sale_price,
            'title' => $this->translation()->title,
            'description' => $this->translation()->description,
            'brand' => [
                'id' => $this->brand->id,
                'name' => $this->brand->name,
            ],
            'productType' => [
                'id' => $this->productType->id,
                'name' => $this->productType->translation()->name,
            ],
            'images' => Image::collection($this->images),
            'mainImage' => new Image($this->mainImage[0]),
            'variants' => Variant::collection($this->variants)
        ];
    }
}
