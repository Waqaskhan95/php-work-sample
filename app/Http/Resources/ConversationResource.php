<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;


class ConversationResource extends JsonResource
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
            'from_user' => new UserResource($this->fromUser) ?? null,
            'to_user' => new UserResource($this->toUser) ?? null,
            'status' => $this->status,
            'created_at' => $this->created_at
        ];
    }
}
