<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\Product;

class OrderDetailListResource extends JsonResource
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
            'id'    => $this->id,
            'order_id'  => $this->order_id,
            'user_id'   => $this->user_id,
            'product'    => new ProductResource(Product::with('images')->find($this->product_id)),
            'product_variation_id' => $this->product_variation_id,
            'quantity'  => $this->quantity,
            'price'     => $this->price,
            'created_at'    => $this->created_at->format('Y-m-d'),
        ];
    }
}
