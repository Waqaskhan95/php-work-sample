<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\Event;
use App\Models\User;


class ItChainResource extends JsonResource
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
            'event' => new EventResource(Event::find($this->event_id)),
            // 'user' => new UserResource(User::find($this->user_id)),
            'created_at' => $this->created_at, 
            'updated_at' => $this->updated_at, 
        ];
    }
}
