<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\User;

class VideoResource extends JsonResource
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
            'user' => new UserResource(User::find($this->user_id)),
            'type' => $this->type,
            'title' => $this->title,
            'description' => $this->description,
            'thumbnail' => $this->thumbnail ?  asset($this->thumbnail) : null,
            'video_location' => $this->video_location ?  asset($this->video_location) : null,
            'country' => $this->country_id ,
            'state' => $this->state_id,
            'city' => $this->city_id,
            'duration' => $this->duration,
            'size' => $this->size,
            'time' => $this->time,
            'comments' => CommentResource::collection($this->comments) ?? null,
        ];
    }   
}
