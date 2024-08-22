<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
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
            'description' => $this->description ?? null,
            'category' => $this->category ? $this->category->name : null,
            'brand' => $this->brand ? $this->brand->name : null,
            'user' => $this->user ? $this->user->name : null,
            'user_id' => $this->user_id ?? null,
            'user_role' => $this->user ? $this->user->role->name : null,
            'ratings' => $this->ratings->isNotEmpty() ? $this->ratings->pluck('rating')->avg() : null,
            'variations' => $this->variations ? ProductVariationResource::collection($this->variations) : null,
            'images' => $this->images ? ImageResource::collection($this->images) : null,
            'created_at' => $this->created_at->format('Y-m-d') ?? null,
            'is_fav' => $this->isFav() ?? null,
        ];
    }
}
