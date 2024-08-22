<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductVariationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name ?? null,
            'price' => $this->price ?? null,
            'stock_quantity' => $this->stock_quantity ?? null,
            'color' => $this->color ? $this->color->name : null,
            'size' => $this->size ? $this->size->name : null,
            'created_at' => $this->created_at->format('Y-m-d') ?? null,
        ];
    }
}
