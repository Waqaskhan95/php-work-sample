<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
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
            'first_name' => $this->first_name ?? null,
            'last_name' => $this->last_name ?? null,
            'email' => $this->email ?? null,
            'role_id' => $this->role_id,
            'role' => $this->role ? $this->role->name : null,
            'gender' => $this->gender ?? null,
            'total_follower' => $this->follower ? $this->follower->count() : 0,
            'avatar'    => $this->avatar ? asset($this->avatar) : null, 
            'created_at' => $this->created_at->format('Y-m-d') ?? null,
            'videos_count' => $this->videos ? $this->videos->count() : null, 
            'phone_number' => $this->phone_number ?? null, 
            'address' => $this->address ?? null, 
            'followers'  => $this->followers? $this->followers->count() : 0,
            'followings' => $this->followings ? $this->followings->count() : 0 ,
            'bio'       => $this->bio  
        ];
    }
}
