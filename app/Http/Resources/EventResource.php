<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\User;

class EventResource extends JsonResource
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
            'name'  => $this->name,
            'user'  => new UserResource(User::find($this->user_id)),
            'category' => $this->category->name ?? null,
            'user_id' => $this->user_id ?? null,
            'category_id' => $this->category_id ?? null,
            'country_id'  => $this->country_id ?? null,
            'country'  => $this->country->name ?? null,
            'state_id'     => $this->state_id ?? null,
            'state'     => $this->state->name ?? null,
            'city_id'      => $this->city_id ?? null,
            'city'      => $this->city->name ?? null,
            'date'      => $this->date,
            'thumbnail' => $this->thumbnail ? asset($this->thumbnail) : null,
            'location'  => $this->location,
            'description'   => $this->description,
            'lat'       => $this->lat,
            'lng'       => $this->lng,
            'created_at'       => $this->created_at->format('Y-m-d'),
        ];
    }
}
