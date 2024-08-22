<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\User;

class OrderResource extends JsonResource
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
            'user'  => new UserResource(User::find($this->user_id)) ?? null,
            'order_number' => $this->order_number,
            'total_amount'  => $this->total_amount,
            'discount'      => $this->discount,
            'items'         => $this->details->count() ?? 0,
            'status'        => $this->status
        ];
    }
}
